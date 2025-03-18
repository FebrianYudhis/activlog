<?php

namespace App\Http\Controllers;

use App\Models\DateSchedule;
use App\Models\Note;
use App\Models\Schedule;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class LogbookController extends Controller
{
    public function index(DateSchedule $dateSchedule)
    {
        $sekarang = Carbon::now('Asia/Jakarta');
        $batasAkhir = Carbon::parse($dateSchedule->due_date, 'Asia/Jakarta');

        $data = [
            'judul' => 'Isi Logbook',
            'dataLogbook' => $dateSchedule->load(['tasks', 'schedule', 'note']),
            'isAllowed' => $sekarang->lt($batasAkhir),
        ];

        $title = 'Hapus Data !';
        $text = "Apakah Kamu Yakin Ingin Menghapus Data Ini ?";
        confirmDelete($title, $text);

        return view('form.task.index', $data);
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

    public function tambahForm()
    {
        $data = [
            'judul' => 'Tambah Tanggal Logbook',
            'minDate' => Carbon::now()->subDay()->toDateString(),
            'dataJadwalDinas' => Schedule::select('id', 'name')->get(),
        ];

        return view('form.logbook.tambah', $data);
    }

    public function tambah(Request $request)
    {
        $minDate = Carbon::now()->subDay()->toDateString();

        $validated = $request->validate([
            'tanggal' => ['required', 'date', 'after_or_equal:' . $minDate],
            'jadwalDinas' => ['required', 'exists:schedules,id'],
        ]);

        $aditionalHours = Schedule::find($validated['jadwalDinas'])->additional_hours;

        $dataJadwal = DateSchedule::create([
            'user_id' => Auth::user()->id,
            'date' => $validated['tanggal'],
            'schedule_id' => $validated['jadwalDinas'],
            'due_date' => Carbon::parse($validated['tanggal'], 'Asia/Jakarta')->addHours($aditionalHours),
        ]);

        if ($dataJadwal) {
            Alert::success('Berhasil', 'Data Berhasil Ditambahkan !');
        } else {
            Alert::error('Gagal', 'Data Gagal Ditambahkan !');
        }

        return redirect()->route('app');
    }

    public function updateCatatan(Note $note, Request $request)
    {
        $validated = $request->validate([
            'catatan' => ['required', 'string'],
        ]);

        $note->update(['note' => $validated['catatan']]);

        Alert::success('Berhasil', 'Catatan Berhasil Diubah !');

        return redirect()->back();
    }

    public function hapusTugas(Task $task)
    {
        $task->delete();

        Alert::success('Berhasil', 'Tugas Berhasil Dihapus !');

        return redirect()->back();
    }
}
