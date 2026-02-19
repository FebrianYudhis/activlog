<?php

namespace App\Http\Controllers;

use App\Models\{DateSchedule, User};
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class PanelController extends Controller
{
    public function index(Request $request)
    {
        $data = [
            'judul' => 'Panel Admin',
            'permintaanHapusLogbook' => DateSchedule::whereNotNull('is_invalid')->with('user', 'schedule')->get(),
            'belumDiperiksaLogbook' => DateSchedule::whereNull('is_invalid')->whereNull('is_checked')->with('user', 'schedule')->get(),
        ];

        if ($request->ajax()) {
            $query = DateSchedule::whereNull('is_invalid')->whereNotNull('is_checked')->with('user', 'schedule');

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

    public function sudahDiperiksa(DateSchedule $dateSchedule)
    {
        $dateSchedule->update(['is_checked' => 1]);
        Alert::success('Berhasil', 'Berhasil Menandai Sudah Diperiksa !');
        return redirect()->back();
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
        $validated = $request->validate([
            'tanggalAwal' => ['required', 'date'],
            'tanggalAkhir' => ['required', 'date', 'after_or_equal:tanggalAwal'],
            'pengguna' => ['required', 'exists:users,id'],
        ]);

        $data = DateSchedule::where('user_id', $validated['pengguna'])
            ->whereBetween('date', [$validated['tanggalAwal'], $validated['tanggalAkhir']])
            ->whereNotNull('is_checked')
            ->with('tasks', 'note', 'user', 'schedule')
            ->orderBy('date')
            ->get();

        if ($data->isEmpty()) {
            Alert::error('Gagal', 'Data Tidak Ditemukan !');
            return redirect()->back();
        }

        $userName = $data->first()->user->name ?? 'Undefined';
        $safeUserName = str_replace(' ', '_', $userName);
        $fileName = "{$safeUserName}_Logbook_{$validated['tanggalAwal']}_sampai_{$validated['tanggalAkhir']}.pdf";

        $pdf = Pdf::loadView('panel.download-pdf', [
            'records' => $data,
            'userName' => $userName,
            'tanggalAwal' => $validated['tanggalAwal'],
            'tanggalAkhir' => $validated['tanggalAkhir'],
        ])->setPaper('a4');

        return $pdf->download($fileName);
    }
}
