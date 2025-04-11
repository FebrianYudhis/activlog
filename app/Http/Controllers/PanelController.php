<?php

namespace App\Http\Controllers;

use App\Models\{DateSchedule, User};
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\{Fill, Border, Alignment};
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Yajra\DataTables\Facades\DataTables;

class PanelController extends Controller
{
    public function index(Request $request)
    {
        $data = [
            'judul' => 'Panel Admin',
            'permintaanHapusLogbook' => DateSchedule::whereNot('is_invalid', null)->with('user', 'schedule')->get(),
        ];

        if ($request->ajax()) {
            $query = DateSchedule::where('is_invalid', null)->with('user', 'schedule');

            return DataTables::of($query)
                ->addColumn('aksi', function ($data) {
                    $button = "<a href='" . route('panel.logbook', $data['id']) . "' class='btn btn-info w-100'>Detail</a>";

                    return $button;
                })->rawColumns(['aksi'])
                ->toJson();
        }

        return view('panel', $data);
    }

    public function logbook(DateSchedule $dateSchedule)
    {
        $data = [
            'judul' => 'Detail Logbook',
            'dataDetail' => DateSchedule::with('user', 'schedule', 'tasks', 'note')->where('id', $dateSchedule->id)->first(),
        ];

        $title = 'Hapus Data !';
        $text = "Apakah Kamu Yakin Ingin Menghapus Data Ini ?";
        confirmDelete($title, $text);

        return view('panel.logbook', $data);
    }

    public function hapusLogbook(DateSchedule $dateSchedule)
    {
        if ($dateSchedule->delete()) {
            Alert::success('Berhasil', 'Data Berhasil Dihapus !');
        } else {
            Alert::error('Gagal', 'Data Gagal Dihapus !');
        }

        return redirect()->route('panel');
    }

    public function downloadDataForm()
    {
        $data = [
            'judul' => 'Download Data',
            'semuaPengguna' => User::all()
        ];

        return view('panel.download', $data);
    }

    public function downloadData(Request $request)
    {
        $data = DateSchedule::where('user_id', $request->pengguna)
            ->whereBetween('date', [$request->tanggalAwal, $request->tanggalAkhir])
            ->whereNotNull('is_checked')
            ->with('tasks', 'note', 'user', 'schedule')
            ->get();

        if ($data->isEmpty()) {
            Alert::error('Gagal', 'Data Tidak Ditemukan !');
            return redirect()->back();
        }

        $spreadsheet = new Spreadsheet();
        $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');

        $userName = str_replace(' ', '_', $data->first()->user->name ?? 'Undefined');
        $fileName = "{$userName}_Logbook.xlsx";

        $sheetNames = [];

        foreach ($data as $index => $item) {
            $baseSheetName = $item->date;
            $sheetName = $baseSheetName;
            $counter = 1;
            while (in_array($sheetName, $sheetNames)) {
                $sheetName = $baseSheetName . " ($counter)";
                $counter++;
            }
            $sheetNames[] = $sheetName;

            $sheet = ($index == 0) ? $spreadsheet->getActiveSheet() : $spreadsheet->createSheet();
            $sheet->setTitle($sheetName);

            $sheet->setCellValue('A1', 'Logbook Harian');
            $sheet->mergeCells('A1:D1');
            $sheet->getStyle('A1')->applyFromArray([
                'font' => ['size' => 18, 'bold' => true],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => '4CBB17']]
            ]);

            $userInfo = [
                ['Nama', $item->user->name ?? 'N/A'],
                ['Tanggal', $item->date],
                ['Jadwal Dinas', $item->schedule->name ?? 'N/A'],
            ];

            $row = 2;
            foreach ($userInfo as [$label, $value]) {
                $sheet->setCellValue("A$row", $label);
                $sheet->mergeCells("A$row:B$row");
                $sheet->setCellValue("C$row", ':');
                $sheet->setCellValue("D$row", $value);
                $sheet->getStyle("B$row")->getAlignment()->setWrapText(true);
                $row++;
            }
            $sheet->mergeCells("A$row:D$row");

            $row += 1;
            $sheet->setCellValue("A$row", 'Kegiatan');
            $sheet->mergeCells("A$row:D$row");
            $sheet->getStyle("A$row")->applyFromArray([
                'font' => ['bold' => true, 'size' => 12],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFD700']],
            ]);

            $row++;
            if (!empty($item->tasks)) {
                foreach ($item->tasks as $task) {
                    $sheet->setCellValue("A$row", '-');
                    $sheet->setCellValue("B$row", $task->task);
                    $sheet->mergeCells("B$row:D$row");
                    $sheet->getStyle("B$row")->getAlignment()->setWrapText(true);
                    $row++;
                }
            } else {
                $sheet->setCellValue("A$row", '#');
                $sheet->mergeCells("A$row:D$row");
                $row++;
            }

            $sheet->mergeCells("A$row:D$row");

            $row += 1;
            $sheet->setCellValue("A$row", 'Catatan');
            $sheet->mergeCells("A$row:D$row");
            $sheet->getStyle("A$row")->applyFromArray([
                'font' => ['bold' => true, 'size' => 12],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => '87CEEB']],
            ]);

            $row++;
            $sheet->setCellValue("A$row", $item->note->note);
            $sheet->mergeCells("A$row:D$row");
            $sheet->getStyle("A$row")->getAlignment()->setWrapText(true);

            $sheet->getStyle("A1:D$row")->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],
            ]);

            foreach (range('A', 'D') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }
        }

        $response = new StreamedResponse(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        });

        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $fileName . '"');
        $response->headers->set('Cache-Control', 'max-age=0');

        return $response;
    }
}
