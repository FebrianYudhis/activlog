<?php

namespace App\Http\Controllers;

use App\Models\DateSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $data = [
            'judul' => 'Beranda'
        ];

        if ($request->ajax()) {
            $query = DateSchedule::with('schedule')
                ->where('user_id', Auth::id());

            return DataTables::of($query)
                ->addColumn('aksi', function ($data) {
                    $sekarang = Carbon::now('Asia/Jakarta');
                    $batasAkhir = Carbon::parse($data['due_date'], 'Asia/Jakarta');

                    $button = "<a href='" . route('logbook', [$data['id']]) . "' class='btn btn-primary w-100'>Lihat</a>";
                    if ($sekarang->lt($batasAkhir)) {
                        $button = $button . "<a href='" . route('logbook.hapus', [$data['id']]) . "' class='btn btn-danger w-100 mt-1' data-confirm-delete='true'>Hapus</a>";
                    }
                    return $button;
                })->rawColumns(['aksi'])
                ->toJson();
        }

        $title = 'Hapus Data !';
        $text = "Apakah Kamu Yakin Ingin Menghapus Data Ini ?";
        confirmDelete($title, $text);

        return view("home", $data);
    }
}
