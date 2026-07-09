<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Add note column to date_schedules
        Schema::table('date_schedules', function (Blueprint $table) {
            $table->text('note')->nullable();
        });

        // 2. Move data from notes table to date_schedules table
        if (Schema::hasTable('notes')) {
            DB::statement('UPDATE date_schedules ds JOIN notes n ON ds.id = n.date_schedule_id SET ds.note = n.note');
            
            // 3. Drop notes table
            Schema::dropIfExists('notes');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 1. Recreate notes table
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('date_schedule_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->text('note');
            $table->timestamps();
        });

        // 2. Move data back from date_schedules to notes
        $dateSchedules = DB::table('date_schedules')->get();
        foreach ($dateSchedules as $ds) {
            DB::table('notes')->insert([
                'date_schedule_id' => $ds->id,
                'note' => $ds->note ?? '-',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 3. Drop note column from date_schedules
        Schema::table('date_schedules', function (Blueprint $table) {
            $table->dropColumn('note');
        });
    }
};
