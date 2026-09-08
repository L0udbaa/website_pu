<?php

use App\Models\Kegiatan;
use App\Models\ProgresFisik;
use App\Models\ProgresKeuangan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('deletes only the selected activity and its progress', function () {
    $user = User::create([
        'nama' => 'Admin Test',
        'username' => 'admin-test',
        'email' => 'admin-test@example.com',
        'password' => 'password',
    ]);
    $selected = Kegiatan::create([
        'user_id' => $user->id,
        'kode_kegiatan' => 'TEST-001',
        'nama_kegiatan' => 'Kegiatan Terpilih',
        'tahun' => 2026,
        'anggaran' => 1000,
    ]);
    $other = Kegiatan::create([
        'user_id' => $user->id,
        'kode_kegiatan' => 'TEST-002',
        'nama_kegiatan' => 'Kegiatan Lain',
        'tahun' => 2026,
        'anggaran' => 2000,
    ]);

    ProgresFisik::create(['kegiatan_id' => $selected->id]);
    ProgresKeuangan::create(['kegiatan_id' => $selected->id]);
    ProgresFisik::create(['kegiatan_id' => $other->id]);
    ProgresKeuangan::create(['kegiatan_id' => $other->id]);

    $response = $this->actingAs($user)->delete(route('kegiatan.destroy', $selected));

    $response->assertRedirect(route('kegiatan.index'));
    expect(Kegiatan::find($selected->id))->toBeNull()
        ->and(ProgresFisik::where('kegiatan_id', $selected->id)->exists())->toBeFalse()
        ->and(ProgresKeuangan::where('kegiatan_id', $selected->id)->exists())->toBeFalse()
        ->and(Kegiatan::find($other->id))->not->toBeNull()
        ->and(ProgresFisik::where('kegiatan_id', $other->id)->exists())->toBeTrue()
        ->and(ProgresKeuangan::where('kegiatan_id', $other->id)->exists())->toBeTrue();
});