<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('progres_keuangan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kegiatan_id')
                ->constrained('kegiatan')
                ->cascadeOnDelete();
            $table->decimal('nilai_kontrak', 15, 2)->default(0);
            $table->decimal('rencana_persen', 5, 2)->default(0);
            $table->date('tanggal_rencana')->nullable();
            $table->decimal('realisasi_persen', 5, 2)->default(0);
            $table->decimal('rencana_keuangan', 15, 2)->default(0);
            $table->date('tanggal_realisasi')->nullable();
            $table->decimal('realisasi_keuangan', 15, 2)->default(0);
            $table->decimal('deviasi_keuangan', 15, 2)->default(0);
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->decimal('progres_keuangan', 15, 2)->nullable()->default(0);
            $table->decimal('proses_keuangan', 15, 2)->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progres_keuangan');
    }
};
