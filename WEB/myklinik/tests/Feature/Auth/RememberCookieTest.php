<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RememberCookieTest extends TestCase
{
    use RefreshDatabase;

    public function test_password_tidak_pernah_disimpan_di_cookie(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email, 'password' => 'password', 'remember' => '1',
        ]);

        $response->assertCookie('loginUser');
        $this->assertTrue($response->getCookie('loginPassword', false)?->isCleared() ?? true);
        foreach ($response->headers->getCookies() as $cookie) {
            $this->assertStringNotContainsString('password', (string) $cookie->getValue());
        }
    }

    public function test_remember_menyetel_remember_token_laravel(): void
    {
        $user = User::factory()->create(['remember_token' => null]);

        $response = $this->post('/login', [
            'email' => $user->email, 'password' => 'password', 'remember' => '1',
        ]);

        $this->assertNotNull($user->fresh()->remember_token);
        $this->assertTrue(collect($response->headers->getCookies())->contains(fn ($c) => str_starts_with($c->getName(), 'remember_web_')));
    }

    public function test_tanpa_remember_cookie_email_dihapus(): void
    {
        $user = User::factory()->create();

        $response = $this->withUnencryptedCookie('loginUser', $user->email)->post('/login', [
            'email' => $user->email, 'password' => 'password',
        ]);

        $this->assertTrue($response->getCookie('loginUser', false)->isCleared());
    }

    public function test_cookie_password_lama_dihapus_saat_login(): void
    {
        $user = User::factory()->create();

        $response = $this->withUnencryptedCookie('loginPassword', 'rahasia')->post('/login', [
            'email' => $user->email, 'password' => 'password',
        ]);

        $this->assertTrue($response->getCookie('loginPassword', false)->isCleared());
    }
}
