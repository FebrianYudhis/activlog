<?php

namespace App\Http\Controllers;

use App\Models\DateSchedule;
use App\Models\User;
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

                    $button = "<a href='" . route('logbook', [$data['id']]) . "' class='btn btn-primary w-100 mt-1'>Lihat</a>";
                    if ($sekarang->lt($batasAkhir)) {
                        $button = $button . "<form action='" . route('logbook.hapus', [$data['id']]) . "' class='mt-1 w-100' method='POST'> " . csrf_field() . method_field('delete') . " <button type='submit' class='btn btn-danger w-100'>Hapus</button></form>";
                    }
                    return $button;
                })->rawColumns(['aksi'])
                ->toJson();
        }

        return view("home", $data);
    }
}
