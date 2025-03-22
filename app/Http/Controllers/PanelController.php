<?php

namespace App\Http\Controllers;

use App\Models\DateSchedule;
use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
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
        $data = DateSchedule::where('user_id', $request->pengguna)->whereBetween('date', [$request->tanggalAwal, $request->tanggalAkhir])->with('tasks', 'note')->get();

        if ($data->isNotEmpty()) {
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil ditemukan',
                'data' => $data
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Data tidak ditemukan'
        ], 404);
    }
}
