<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgresFisik extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'progres_fisik';

    protected $fillable = [
        'kegiatan_id',
        'tanggal_rencana',
        'rencana_fisik',
        'tanggal_realisasi',
        'realisasi_fisik',
        'deviasi_fisik',
    ];

    protected $casts = [
        'tanggal_rencana' => 'date',
        'tanggal_realisasi' => 'date',
        'rencana_fisik' => 'decimal:2',
        'realisasi_fisik' => 'decimal:2',
        'deviasi_fisik' => 'decimal:2',
    ];

    public function kegiatan(): BelongsTo
    {
        return $this->belongsTo(Kegiatan::class);
    }

    public function scopeLatestPerKegiatan(Builder $query): Builder
    {
        return $query->whereIn(
            $this->getTable() . '.id',
            static::query()
                ->selectRaw('MAX(id)')
                ->groupBy('kegiatan_id')
        );
    }
}
 