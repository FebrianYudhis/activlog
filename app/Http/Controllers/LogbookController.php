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
            } else {
                Alert::error('Gagal', 'Data Gagal Dihapus !');
            }
        } else {
            Alert::error('Gagal', 'Anda Tidak Berhak Menghapus Data !');
        }

        return redirect()->route('app');
    }

    public function updateStatus($status, DateSchedule $dateSchedule)
    {
        $sekarang = Carbon::now('Asia/Jakarta');
        $batasAkhir = Carbon::parse($dateSchedule->due_date, 'Asia/Jakarta');

        if ($dateSchedule->user->id == Auth::user()->id and $sekarang->gt($batasAkhir) and $dateSchedule->tasks->count() == 0) {
            if ($status == 1) {
                $dateSchedule->update(['is_invalid' => 1]);
                Alert::success('Berhasil', 'Berhasil Minta Hapus !');
            } else {
                $dateSchedule->update(['is_invalid' => null]);
                Alert::success('Berhasil', 'Berhasil Membatalkan Minta Hapus !');
            }
        } else {
            Alert::error('Gagal', 'Anda Tidak Berhak Mengubah Data !');
            return redirect()->route('app');
        }

        return redirect()->route('app');
    }
}
