<?php

namespace Tests\Feature;

use App\Models\Poliklinik;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\Concerns\BuildsClinicData;
use Tests\TestCase;

class PaksaGantiPasswordTest extends TestCase
{
    use RefreshDatabase, BuildsClinicData;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seedRoles();
    }

    private function userWajibGanti(int $roleId = 3): User
    {
        return User::factory()->create(['role_id' => $roleId, 'must_change_password' => true]);
    }

    public function test_karyawan_baru_dari_admin_wajib_ganti_password_dan_passwordnya_nip(): void
    {
        $this->actingAs($this->makeUser(2))->post(route('adm.karyawan.save'), [
            'nip' => 'ST-001', 'email' => 'staf@example.com', 'name' => 'Staf', 'sex' => 'L',
            'role_id' => base64_encode('3'),
        ])->assertSessionHas('success');

        $user = User::where('email', 'staf@example.com')->firstOrFail();
        $this->assertTrue($user->must_change_password);
        $this->assertTrue(Hash::check('ST-001', $user->password));
    }

    public function test_dokter_baru_dari_admin_wajib_ganti_password(): void
    {
        $poli = Poliklinik::create(['name' => 'umum']);

        $this->actingAs($this->makeUser(2))->post(route('adm.dokter.save'), [
            'nip' => 'DK-001', 'izin' => '123', 'email' => 'dr@example.com', 'name' => 'Dr',
            'poli_id' => base64_encode($poli->id), 'sex' => 'P',
        ])->assertSessionHas('success');

        $this->assertTrue(User::where('email', 'dr@example.com')->firstOrFail()->must_change_password);
    }

    public function test_user_wajib_ganti_diarahkan_dari_halaman_lain(): void
    {
        $this->actingAs($this->userWajibGanti())
            ->get(route('front.dashboard'))
            ->assertRedirect(route('password.force'));
    }

    public function test_user_wajib_ganti_bisa_membuka_form_dan_logout(): void
    {
        $user = $this->userWajibGanti();

        $this->actingAs($user)->get(route('password.force'))->assertOk();
        $this->actingAs($user)->post(route('logout'))->assertRedirect('/');
        $this->assertGuest();
    }

    public function test_ganti_password_berhasil_membuka_akses(): void
    {
        $user = $this->userWajibGanti();

        $this->actingAs($user)->put(route('password.force.update'), [
            'current_password' => 'password',
            'password' => 'PasswordBaru123!',
            'password_confirmation' => 'PasswordBaru123!',
        ])->assertSessionHasNoErrors()->assertRedirect('/');

        $user->refresh();
        $this->assertFalse($user->must_change_password);
        $this->assertTrue(Hash::check('PasswordBaru123!', $user->password));
        $this->actingAs($user)->get(route('front.dashboard'))->assertOk();
    }

    public function test_password_lama_salah_atau_sama_ditolak(): void
    {
        $user = $this->userWajibGanti();

        $this->actingAs($user)->put(route('password.force.update'), [
            'current_password' => 'salah',
            'password' => 'PasswordBaru123!', 'password_confirmation' => 'PasswordBaru123!',
        ])->assertSessionHasErrors('current_password');

        $this->actingAs($user)->put(route('password.force.update'), [
            'current_password' => 'password',
            'password' => 'password', 'password_confirmation' => 'password',
        ])->assertSessionHasErrors('password');

        $this->assertTrue($user->fresh()->must_change_password);
    }

    public function test_user_biasa_tidak_terpengaruh_dan_form_force_redirect(): void
    {
        $user = $this->makeUser(3);

        $this->actingAs($user)->get(route('front.dashboard'))->assertOk();
        $this->actingAs($user)->get(route('password.force'))->assertRedirect('/');
    }
}
