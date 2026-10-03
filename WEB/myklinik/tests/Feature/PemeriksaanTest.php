<?php

namespace Tests\Feature;

use App\Models\Rekam;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\BuildsClinicData;
use Tests\TestCase;

class PemeriksaanTest extends TestCase
{
    use RefreshDatabase, BuildsClinicData;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seedRoles();
    }

    private function buatRekam($dokter, $pasien, int $status = 0): Rekam
    {
        $rekam = new Rekam([
            'dokter_id' => $dokter->id, 'kode_rekam' => 'RKM-' . uniqid(), 'tekanan_darah' => '120',
            'rate' => '80', 'suhu_badan' => '36', 'berat_badan' => '60', 'tinggi_badan' => '165',
            'keluhan_utama' => 'Demam', 'created_by' => 'petugas', 'status' => $status,
        ]);
        $rekam->pasien_id = $pasien->id;
        $rekam->save();

        return $rekam;
    }

    public function test_proses_mengubah_rekam_pertama_menjadi_sedang_diperiksa(): void
    {
        $dokter = $this->makeDokter();
        $rekam = $this->buatRekam($dokter, $this->makePasien());
        $dokterUser = $dokter->karyawan_id ? \App\Models\Karyawans::find($dokter->karyawan_id)->user_id : null;

        $this->actingAs(\App\Models\User::find($dokterUser))
            ->get(route('dokter.pemeriksaan.proses'))
            ->assertOk();

        $this->assertSame(1, (int) $rekam->fresh()->status);
    }

    public function test_proses_tanpa_pasien_redirect_dengan_pesan(): void
    {
        $dokter = $this->makeDokter();
        $user = \App\Models\User::find(\App\Models\Karyawans::find($dokter->karyawan_id)->user_id);

        $this->actingAs($user)
            ->get(route('dokter.pemeriksaan.proses'))
            ->assertRedirect(route('dokter.pemeriksaan'))
            ->assertSessionHas('delete');
    }

    public function test_selesai_periksa_menyimpan_diagnosis_tindakan_dan_status(): void
    {
        $dokter = $this->makeDokter();
        $rekam = $this->buatRekam($dokter, $this->makePasien(), 1);
        $user = \App\Models\User::find(\App\Models\Karyawans::find($dokter->karyawan_id)->user_id);

        $this->actingAs($user)
            ->post(route('dokter.pemeriksaan.selesai'), [
                'rekam_id' => base64_encode($rekam->id),
                'diagnosa' => 'Flu',
                'deskripsi_tindakan' => 'Istirahat',
            ])
            ->assertRedirect(route('dokter.pemeriksaan'))
            ->assertSessionHas('success');

        $rekam->refresh();
        $this->assertSame(2, (int) $rekam->status);
        $this->assertSame('Flu', $rekam->diagnosis);
        $this->assertSame('Istirahat', $rekam->deskripsi_tindakan);
    }

    public function test_selesai_periksa_validasi_gagal_tanpa_diagnosa(): void
    {
        $dokter = $this->makeDokter();
        $rekam = $this->buatRekam($dokter, $this->makePasien(), 1);
        $user = \App\Models\User::find(\App\Models\Karyawans::find($dokter->karyawan_id)->user_id);

        $this->actingAs($user)
            ->post(route('dokter.pemeriksaan.selesai'), [
                'rekam_id' => base64_encode($rekam->id), 'deskripsi_tindakan' => 'x',
            ])
            ->assertSessionHasErrors('diagnosa');
        $this->assertSame(1, (int) $rekam->fresh()->status);
    }

    public function test_error_saat_simpan_di_rollback_dengan_pesan_error(): void
    {
        $dokter = $this->makeDokter();
        $user = \App\Models\User::find(\App\Models\Karyawans::find($dokter->karyawan_id)->user_id);

        // rekam tidak ada -> ModelNotFoundException harus tertangkap (bukan Mockery\Exception)
        $this->actingAs($user)
            ->post(route('dokter.pemeriksaan.selesai'), [
                'rekam_id' => base64_encode(9999), 'diagnosa' => 'a', 'deskripsi_tindakan' => 'b',
            ])
            ->assertRedirect(route('dokter.pemeriksaan'))
            ->assertSessionHasErrors('error');
    }
}
