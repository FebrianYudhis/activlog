<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PanelController extends Controller
{
    public function index()
    {
        $data = [
            'judul' => 'Panel Admin'
        ];

        return view('panel', $data);
    }
}
