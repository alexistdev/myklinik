<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
   /**
        * Author: AlexistDev
        * Email: Alexistdev@gmail.com
        * Phone: 082371408678
        * Github: https://github.com/alexistdev
        */

    public function create(): View
    {
        return view('auth.login',[
            'title' => "Login | Aplikasi My Klinik ",
        ]);
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();
        $roleId = (Int) $user->role_id;

        switch ($roleId){
            case 1:
                return redirect()->intended(RouteServiceProvider::AUDIT);
            case 2:
                return redirect()->intended(RouteServiceProvider::ADMIN);
            case 3:
                return redirect()->intended(RouteServiceProvider::PENDAFTARAN);
            case 4:
                return redirect()->intended(RouteServiceProvider::DOKTER);
            case 5:
                return redirect()->intended(RouteServiceProvider::APOTIK);
            case 6:
                return redirect()->intended(RouteServiceProvider::USER);
            default:
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                abort('404','NOT FOUND');
        }
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
