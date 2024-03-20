<?php

/******************************************************************************
 *                                                                            *
 *  * Copyright (c) 2024.                                                     *
 *  * Develop By: Alexsander Hendra Wijaya                                    *
 *  * Github: https://github.com/alexistdev                                   *
 *  * Phone : 0823-7140-8678                                                  *
 *  * Email : Alexistdev@gmail.com                                            *
 *                                                                            *
 ******************************************************************************/

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Karyawans;
use App\Models\Rekam;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class DataRekamController extends Controller
{
    protected User $users;
    protected Karyawans $karyawans;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->users = Auth::user();
            $this->karyawans = Karyawans::with('dokter')->where('user_id', $this->users->id)->first();
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $rekam = Rekam::where('dokter_id', $this->karyawans->dokter->id)->get();
        return view('dokter.pemeriksaan', array(
            'title' => "Dashboard Administrator | MyKlinik v.1.0",
            'firstMenu' => 'pemeriksaan',
            'secondMenu' => 'pemeriksaan',
            'dataRekam' => $rekam
        ));
    }
}
