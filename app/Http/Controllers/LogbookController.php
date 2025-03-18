<?php

namespace App\Http\Controllers;

use App\Models\DateSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class LogbookController extends Controller
{
    public function index(DateSchedule $dateSchedule)
    {
        return $dateSchedule->load(['tasks', 'schedule', 'note']);
    }

    public function hapus(DateSchedule $dateSchedule)
    {
        $sekarang = Carbon::now('Asia/Jakarta');
        $batasAkhir = Carbon::parse($dateSchedule->due_date, 'Asia/Jakarta');

        if ($dateSchedule->user->id == Auth::user()->id and $sekarang->lt($batasAkhir)) {
            if ($dateSchedule->delete()) {
                Alert::success('Berhasil', 'Data Berhasil Dihapus !');
                return redirect()->route('app');
            } else {
                Alert::error('Gagal', 'Data Gagal Dihapus !');
                return redirect()->route('app');
            }
        } else {
            Alert::error('Gagal', 'Anda Tidak Berhak Menghapus Data !');
            return redirect()->route('app');
        }
    }
}
