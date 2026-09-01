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
        Schema::create('progres_fisik', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kegiatan_id')
                ->constrained('kegiatan')
                ->cascadeOnDelete();
            $table->date('tanggal_rencana')->nullable();
            $table->decimal('rencana_fisik', 5, 2)->default(0);
            $table->date('tanggal_realisasi')->nullable();
            $table->decimal('realisasi_fisik', 5, 2)->default(0);
            $table->decimal('deviasi_fisik', 5, 2)->default(0);
            $table->timestamp('created_at')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progres_fisik');
    }
};
