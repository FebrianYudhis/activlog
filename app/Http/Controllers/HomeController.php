<?php

namespace App\Http\Controllers;

use App\Models\DateSchedule;
use App\Models\User;
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
                    return "<a href='" . route('logbook', [$data['id']]) . "' class='btn btn-primary col-md-12 mt-1'>Lihat</a>";
                })->rawColumns(['aksi'])
                ->toJson();
        }

        return view("home", $data);
    }
}
