<?php

namespace Tests\Feature;

use App\Models\Antrian;
use App\Models\Pasien;
use App\Models\Rekam;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\BuildsClinicData;
use Tests\TestCase;

class PendaftaranTest extends TestCase
{
    use RefreshDatabase, BuildsClinicData;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seedRoles();
    }

    public function test_pasien_baru_membuat_pasien_rekam_dan_antrian(): void
    {
        $dokter = $this->makeDokter();
        $petugas = $this->makeUser(3);

        $this->actingAs($petugas)
            ->post(route('front.pendaftaran.save'), $this->pasienPayload($dokter))
            ->assertRedirect(route('front.pendaftaran'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('pasiens', ['kode_pasien' => 'AGTS-NEW-1', 'nama_lengkap' => 'Siti']);
        $rekam = Rekam::first();
        $this->assertSame(0, (int) $rekam->status);
        $this->assertSame($dokter->id, (int) $rekam->dokter_id);
        $this->assertSame($petugas->name, $rekam->created_by);
        $this->assertSame(1, (int) $rekam->antrian->nomor);
    }

    public function test_pasien_lama_diperbarui_dan_tidak_diduplikasi(): void
    {
        $dokter = $this->makeDokter();
        $pasien = $this->makePasien('AGTS-OLD-1');

        $this->actingAs($this->makeUser(3))
            ->post(route('front.pendaftaran.save'), $this->pasienPayload($dokter, [
                'kode_pasien' => 'AGTS-OLD-1', 'nama_lengkap' => 'Budi Baru',
            ]))
            ->assertSessionHas('success');

        $this->assertSame(1, Pasien::count());
        $this->assertSame('Budi Baru', $pasien->fresh()->nama_lengkap);
        $this->assertSame(1, Rekam::where('pasien_id', $pasien->id)->count());
    }

    public function test_nomor_antrian_bertambah_dan_kode_rekam_unik(): void
    {
        $dokter = $this->makeDokter();
        $petugas = $this->makeUser(3);

        foreach (['A-1', 'A-2', 'A-3'] as $kode) {
            $this->actingAs($petugas)->post(route('front.pendaftaran.save'), $this->pasienPayload($dokter, ['kode_pasien' => $kode]));
        }

        $this->assertSame([1, 2, 3], Antrian::orderBy('id')->pluck('nomor')->map(fn ($n) => (int) $n)->all());
        $this->assertSame(3, Rekam::pluck('kode_rekam')->unique()->count());
    }

    public function test_kode_rekam_tidak_bentrok_dengan_kode_pasien(): void
    {
        $dokter = $this->makeDokter();
        $this->actingAs($this->makeUser(3))
            ->post(route('front.pendaftaran.save'), $this->pasienPayload($dokter));

        $this->assertMatchesRegularExpression('/^RKM-\d{6}-00000001$/', Rekam::first()->kode_rekam);
    }

    public function test_generate_kode_pasien_menaikkan_nomor_dan_tidak_hang_saat_bentrok(): void
    {
        $this->makePasien('X');
        $prefix = 'AGTS-' . date('mY') . '-';
        // id berikutnya = 3; kode itu sudah dipakai pasien lain -> harus lanjut ke 4
        $this->makePasien($prefix . '0000003');

        $kode = $this->actingAs($this->makeUser(3))
            ->get(route('front.ajax.getCode'))->json();

        $this->assertSame($prefix . '0000004', $kode);
    }

    public function test_validasi_gagal_tanpa_dokter(): void
    {
        $dokter = $this->makeDokter();
        $payload = $this->pasienPayload($dokter);
        unset($payload['dokter_id']);

        $this->actingAs($this->makeUser(3))
            ->post(route('front.pendaftaran.save'), $payload)
            ->assertSessionHasErrors('dokter_id');
        $this->assertSame(0, Rekam::count());
    }

    public function test_role_lain_tidak_boleh_mendaftarkan_pasien(): void
    {
        $dokter = $this->makeDokter();
        $this->actingAs($this->makeUser(5))
            ->post(route('front.pendaftaran.save'), $this->pasienPayload($dokter))
            ->assertNotFound();
    }
}
