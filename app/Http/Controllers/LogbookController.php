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
            'batasAkhir' => $batasAkhir,
        ];

        $title = 'Hapus Data !';
        $text = "Apakah Kamu Yakin Ingin Menghapus Data Ini ?";
        confirmDelete($title, $text);

        return view('form.task.index', $data);
    }

    public function tambahForm()
    {
        $data = [
            'judul' => 'Tambah Tanggal Logbook',
            'dataJadwalDinas' => Schedule::select('id', 'name')->get(),
        ];

        return view('form.logbook.tambah', $data);
    }

    public function tambah(Request $request)
    {

        $validated = $request->validate([
            'tanggal' => ['required', 'date'],
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

    public function updateStatus(DateSchedule $dateSchedule, $status)
    {
        $sekarang = Carbon::now('Asia/Jakarta');
        $batasAkhir = Carbon::parse($dateSchedule->due_date, 'Asia/Jakarta');

        if ($dateSchedule->user->id == Auth::user()->id and $sekarang->gt($batasAkhir) and $dateSchedule->tasks->count() == 0) {
            if ($status == 1) {
                $dateSchedule->update(['is_invalid' => 1, 'invalid_reason' => request()->input('alasan')]);
                Alert::success('Berhasil', 'Berhasil Minta Hapus !');
            } else {
                $dateSchedule->update(['is_invalid' => null, 'invalid_reason' => null]);
                Alert::success('Berhasil', 'Berhasil Membatalkan Minta Hapus !');
            }
        } else {
            Alert::error('Gagal', 'Anda Tidak Berhak Mengubah Data !');
            return redirect()->route('app');
        }

        return redirect()->route('app');
    }

    public function updateCatatan(Note $note, Request $request)
    {
        $validated = $request->validate([
            'catatan' => ['required', 'string'],
        ]);

        $sekarang = Carbon::now('Asia/Jakarta');
        $batasAkhir = Carbon::parse($note->dateSchedule->due_date, 'Asia/Jakarta');

        if ($note->dateSchedule->user->id == Auth::user()->id and $sekarang->lt($batasAkhir)) {
            if ($note->update(['note' => $validated['catatan']])) {
                Alert::success('Berhasil', 'Catatan Berhasil Diubah !');
            } else {
                Alert::error('Gagal', 'Catatan Gagal Diubah !');
            }
        } else {
            Alert::error('Gagal', 'Anda Tidak Berhak Mengubah Data !');
        }

        return redirect()->back();
    }

    public function tambahTaskForm(DateSchedule $dateSchedule)
    {
        $data = [
            'judul' => 'Tambah Tugas',
            'dataLogbook' => $dateSchedule,
        ];

        return view('form.task.tambah', $data);
    }

    public function tambahTask(DateSchedule $dateSchedule, Request $request)
    {
        $validated = $request->validate([
            'tugas' => ['required', 'string'],
        ]);

        $sekarang = Carbon::now('Asia/Jakarta');
        $batasAkhir = Carbon::parse($dateSchedule->due_date, 'Asia/Jakarta');

        if ($dateSchedule->user->id == Auth::user()->id and $sekarang->lt($batasAkhir)) {
            $dataTugas = Task::create([
                'date_schedule_id' => $dateSchedule->id,
                'task' => $validated['tugas'],
            ]);

            if ($dataTugas) {
                Alert::success('Berhasil', 'Tugas Berhasil Ditambahkan !');
            } else {
                Alert::error('Gagal', 'Tugas Gagal Ditambahkan !');
            }
        } else {
            Alert::error('Gagal', 'Anda Tidak Berhak Mengubah Data !');
        }

        return redirect()->route('logbook', $dateSchedule->id);
    }

    public function hapusTugas(Task $task)
    {
        $sekarang = Carbon::now('Asia/Jakarta');
        $batasAkhir = Carbon::parse($task->dateSchedule->due_date, 'Asia/Jakarta');

        if ($task->dateSchedule->user->id == Auth::user()->id and $sekarang->lt($batasAkhir)) {
            if ($task->delete()) {
                Alert::success('Berhasil', 'Tugas Berhasil Dihapus !');
            } else {
                Alert::error('Gagal', 'Tugas Gagal Dihapus !');
            }
        } else {
            Alert::error('Gagal', 'Anda Tidak Berhak Mengubah Data !');
        }

        return redirect()->back();
    }
}
