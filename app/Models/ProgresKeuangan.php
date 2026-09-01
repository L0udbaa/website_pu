<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgresKeuangan extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'progres_keuangan';

    protected $fillable = [
        'kegiatan_id',
        'nilai_kontrak',
        'rencana_persen',
        'tanggal_rencana',
        'realisasi_persen',
        'rencana_keuangan',
        'tanggal_realisasi',
        'realisasi_keuangan',
        'deviasi_keuangan',
        'progres_keuangan',
        'proses_keuangan',
    ];

    public function kegiatan(): BelongsTo
    {
        return $this->belongsTo(Kegiatan::class);
    }
}
