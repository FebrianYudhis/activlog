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
                    return view('components.action-buttons', compact('data'))->render();
                })->rawColumns(['aksi'])
                ->toJson();
        }

        $title = 'Hapus Data !';
        $text = "Apakah Kamu Yakin Ingin Menghapus Data Ini ?";
        confirmDelete($title, $text);

        return view("home", $data);
    }
}
