<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kegiatan extends Model
{
    use HasFactory;
    protected $table = 'kegiatan';
    public $timestamps = false;

    protected $fillable = ['user_id', 'kode_kegiatan', 'nama_kegiatan', 'lokasi', 'tahun', 'anggaran'];

    protected $casts = [
        'anggaran' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function progresFisik(): HasMany
    {
        return $this->hasMany(ProgresFisik::class);
    }

    public function progresKeuangan(): HasMany
    {
        return $this->hasMany(ProgresKeuangan::class);
    }
}
