<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;

class BypassController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
            'time' => 'required',
            'task' => 'required|string'
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized: Invalid username or password.'
            ], 401);
        }

        $today = Carbon::now()->format('Y-m-d');
        
        $dateSchedule = $user->dateSchedules()->where('date', $today)->latest('id')->first();

        if (!$dateSchedule) {
            $dateSchedule = $user->dateSchedules()->latest('id')->first();
        }

        if (!$dateSchedule) {
            return response()->json([
                'success' => false,
                'message' => 'Failed: No logbook entry (DateSchedule) found for this user. Please create a schedule first.'
            ], 404);
        }

        $task = $dateSchedule->tasks()->create([
            'time' => $request->time,
            'task' => $request->task,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Task successfully added.',
            'data' => $task
        ]);
    }
}
