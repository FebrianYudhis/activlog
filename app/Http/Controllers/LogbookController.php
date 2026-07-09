<?php

namespace App\Http\Controllers;

use App\Models\DateSchedule;
// use App\Models\Note;
use App\Models\Schedule;
use App\Models\Task;
use App\Http\Requests\LogbookStoreRequest;
use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\NoteUpdateRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class LogbookController extends Controller
{
    public function index(Request $request, DateSchedule $dateSchedule)
    {
        if ($request->user()->cannot('view', $dateSchedule)) {
            Alert::error('Gagal', 'Anda Tidak Berhak Mengakses Data Ini !');
            return redirect()->route('app');
        }

        $data = [
            'judul' => 'Isi Logbook',
            'dataLogbook' => $dateSchedule->load(['tasks', 'schedule']),
            'isAllowed' => now()->lt($dateSchedule->due_date),
            'batasAkhir' => Carbon::parse($dateSchedule->due_date),
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

    public function tambah(LogbookStoreRequest $request)
    {
        $validated = $request->validated();
        $aditionalHours = Schedule::find($validated['jadwalDinas'])->additional_hours;

        $dataJadwal = $request->user()->dateSchedules()->create([
            'date' => $validated['tanggal'],
            'schedule_id' => $validated['jadwalDinas'],
            'due_date' => Carbon::parse($validated['tanggal'])->addHours($aditionalHours),
        ]);

        if ($dataJadwal) {
            Alert::success('Berhasil', 'Data Berhasil Ditambahkan !');
        } else {
            Alert::error('Gagal', 'Data Gagal Ditambahkan !');
        }

        return redirect()->route('app');
    }

    public function hapus(Request $request, DateSchedule $dateSchedule)
    {
        if ($request->user()->cannot('delete', $dateSchedule)) {
            Alert::error('Gagal', 'Anda Tidak Berhak Menghapus Data !');
            return redirect()->route('app');
        }

        if ($dateSchedule->delete()) {
            Alert::success('Berhasil', 'Data Berhasil Dihapus !');
        } else {
            Alert::error('Gagal', 'Data Gagal Dihapus !');
        }

        return redirect()->route('app');
    }

    public function updateStatus(Request $request, DateSchedule $dateSchedule, $status)
    {
        if ($request->user()->cannot('updateStatus', $dateSchedule)) {
            Alert::error('Gagal', 'Anda Tidak Berhak Mengubah Data !');
            return redirect()->route('app');
        }

        if ($status == 1) {
            $dateSchedule->update([
                'is_invalid' => 1, 
                'invalid_reason' => $request->input('alasan')
            ]);
            Alert::success('Berhasil', 'Berhasil Minta Hapus !');
        } else {
            $dateSchedule->update([
                'is_invalid' => null, 
                'invalid_reason' => null
            ]);
            Alert::success('Berhasil', 'Berhasil Membatalkan Minta Hapus !');
        }

        return redirect()->route('app');
    }

    public function updateCatatan(NoteUpdateRequest $request, DateSchedule $dateSchedule)
    {
        if ($request->user()->cannot('updateNote', $dateSchedule)) {
            Alert::error('Gagal', 'Anda Tidak Berhak Mengubah Data !');
            return redirect()->back();
        }

        if ($dateSchedule->update(['note' => $request->validated('catatan')])) {
            Alert::success('Berhasil', 'Catatan Berhasil Diubah !');
        } else {
            Alert::error('Gagal', 'Catatan Gagal Diubah !');
        }

        return redirect()->back();
    }

    public function tambahTaskForm(Request $request, DateSchedule $dateSchedule)
    {
        if ($request->user()->cannot('manageTask', $dateSchedule)) {
            Alert::error('Gagal', 'Anda Tidak Berhak Menambah Tugas !');
            return redirect()->route('app');
        }

        $data = [
            'judul' => 'Tambah Tugas',
            'dataLogbook' => $dateSchedule,
        ];

        return view('form.task.tambah', $data);
    }

    public function tambahTask(TaskStoreRequest $request, DateSchedule $dateSchedule)
    {
        if ($request->user()->cannot('manageTask', $dateSchedule)) {
            Alert::error('Gagal', 'Anda Tidak Berhak Mengubah Data !');
            return redirect()->route('logbook', $dateSchedule->id);
        }

        $dataTugas = $dateSchedule->tasks()->create([
            'task' => $request->validated('tugas'),
            'time' => $request->validated('waktu'),
        ]);

        if ($dataTugas) {
            Alert::success('Berhasil', 'Tugas Berhasil Ditambahkan !');
        } else {
            Alert::error('Gagal', 'Tugas Gagal Ditambahkan !');
        }

        return redirect()->route('logbook', $dateSchedule->id);
    }

    public function hapusTugas(Request $request, Task $task)
    {
        if ($request->user()->cannot('delete', $task)) {
            Alert::error('Gagal', 'Anda Tidak Berhak Mengubah Data !');
            return redirect()->back();
        }

        if ($task->delete()) {
            Alert::success('Berhasil', 'Tugas Berhasil Dihapus !');
        } else {
            Alert::error('Gagal', 'Tugas Gagal Dihapus !');
        }

        return redirect()->back();
    }
}
