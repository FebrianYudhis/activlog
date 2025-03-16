<?php

namespace App\Http\Controllers;

use App\Models\DateSchedule;
use Illuminate\Http\Request;

class LogbookController extends Controller
{
    public function index(DateSchedule $dateSchedule)
    {
        return $dateSchedule->load(['tasks', 'schedule', 'note']);
    }
}
