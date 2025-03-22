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
            $query = DateSchedule::with('schedule', 'tasks')
                ->where('user_id', Auth::id());

            return DataTables::of($query)
                ->addColumn('aksi', function ($data) {
                    $sekarang = Carbon::now('Asia/Jakarta');
                    $batasAkhir = Carbon::parse($data['due_date'], 'Asia/Jakarta');

                    $button = "<a href='" . route('logbook', $data['id']) . "' class='btn btn-primary w-100'>Lihat</a>";

                    if ($data['tasks']->count() == 0 and $sekarang->gt($batasAkhir)) {
                        if ($data['is_invalid'] == null) {
                            $button = $button . "<button class='btn btn-warning w-100 mt-1 mintaHapus' data-id='" . $data['id'] . "'>Minta Hapus</button>";
                        } else {
                            $button = $button . "
                            <form action='" . route('logbook.status', [$data['id'], 0]) . "' class='mt-1 w-100' method='POST'> 
                                " . csrf_field() . method_field('patch') . "
                                <button type='submit' class='btn btn-success w-100'>Batalkan Minta Hapus</button>
                            </form>";
                        }
                    } else if ($sekarang->lt($batasAkhir)) {
                        $button = $button . "<a href='" . route('logbook.hapus', $data['id']) . "' class='btn btn-danger w-100 mt-1' data-confirm-delete='true'>Hapus</a>";
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
