<?php

namespace Tests\Concerns;

use App\Models\Dokter;
use App\Models\Karyawans;
use App\Models\Pasien;
use App\Models\Poliklinik;
use App\Models\Role;
use App\Models\User;

trait BuildsClinicData
{
    protected function seedRoles(): void
    {
        foreach (["audit", "admin", "pendaftaran", "dokter", "apotik", "user"] as $i => $name) {
            Role::forceCreate(['id' => $i + 1, 'name' => $name]);
        }
    }

    protected function makeUser(int $roleId): User
    {
        return User::factory()->create(['role_id' => $roleId]);
    }

    protected function makeDokter(): Dokter
    {
        $user = $this->makeUser(4);
        $karyawan = Karyawans::create([
            'user_id' => $user->id, 'nip' => 'DK-' . $user->id, 'sex' => 'L',
            'tanggal_bergabung' => date('Y-m-d'),
        ]);
        $poli = Poliklinik::create(['name' => 'umum']);

        return Dokter::create([
            'karyawan_id' => $karyawan->id, 'poliklinik_id' => $poli->id, 'no_izin' => '123',
        ]);
    }

    protected function makePasien(string $kode = 'AGTS-000001'): Pasien
    {
        return Pasien::create([
            'kode_pasien' => $kode, 'nama_lengkap' => 'Budi', 'tanggal_lahir' => '1990-01-01',
            'tempat_lahir' => 'Bogor', 'sex' => 'L', 'agama' => 'islam', 'pendidikan' => 'sma',
            'gol_darah' => 'O',
        ]);
    }

    protected function pasienPayload(Dokter $dokter, array $override = []): array
    {
        return array_merge([
            'kode_pasien' => 'AGTS-NEW-1', 'nama_lengkap' => 'Siti', 'tempat_lahir' => 'Bogor',
            'tanggal_lahir' => '1995-05-05', 'sex' => 'P', 'agama' => 'islam', 'pendidikan' => 'sma',
            'golongan_darah' => 'A', 'tekanan_darah' => '120', 'rate' => '80', 'suhu_badan' => '36',
            'berat_badan' => '60', 'tinggi_badan' => '165', 'keluhan_utama' => 'Demam',
            'dokter_id' => base64_encode($dokter->id),
        ], $override);
    }
}
