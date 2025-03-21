<?php

namespace App\Http\Controllers;

use App\Models\DateSchedule;
use Illuminate\Http\Request;

class PanelController extends Controller
{
    public function index()
    {
        $data = [
            'judul' => 'Panel Admin',
            'permintaanHapusLogbook' => DateSchedule::whereNot('is_invalid', null)->orderBy('created_at', 'desc')->with('user', 'schedule')->get(),
        ];

        return view('panel', $data);
    }

    public function detail(DateSchedule $dateSchedule)
    {
        $data = [
            'judul' => 'Detail Logbook',
            'dataDetail' => $dateSchedule->with('user', 'schedule', 'note', 'tasks')->first(),
        ];

        return view('panel.detail', $data);
    }
}
