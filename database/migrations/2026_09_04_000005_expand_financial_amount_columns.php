<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kegiatan', function (Blueprint $table) {
            $table->decimal('anggaran', 20, 2)->default(0)->change();
        });

        Schema::table('progres_keuangan', function (Blueprint $table) {
            $table->decimal('nilai_kontrak', 20, 2)->default(0)->change();
            $table->decimal('rencana_keuangan', 20, 2)->default(0)->change();
            $table->decimal('realisasi_keuangan', 20, 2)->default(0)->change();
            $table->decimal('deviasi_keuangan', 20, 2)->default(0)->change();
            $table->decimal('progres_keuangan', 20, 2)->nullable()->default(0)->change();
            $table->decimal('proses_keuangan', 20, 2)->nullable()->default(0)->change();
        });
    }

    public function down(): void
    {
        Schema::table('kegiatan', function (Blueprint $table) {
            $table->decimal('anggaran', 15, 2)->default(0)->change();
        });

        Schema::table('progres_keuangan', function (Blueprint $table) {
            $table->decimal('nilai_kontrak', 15, 2)->default(0)->change();
            $table->decimal('rencana_keuangan', 15, 2)->default(0)->change();
            $table->decimal('realisasi_keuangan', 15, 2)->default(0)->change();
            $table->decimal('deviasi_keuangan', 15, 2)->default(0)->change();
            $table->decimal('progres_keuangan', 15, 2)->nullable()->default(0)->change();
            $table->decimal('proses_keuangan', 15, 2)->nullable()->default(0)->change();
        });
    }
};