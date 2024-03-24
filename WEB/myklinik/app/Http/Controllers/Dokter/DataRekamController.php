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
use Illuminate\Support\Facades\Auth;

class DataRekamController extends Controller
{
    protected User $users;

    protected int $dokterID;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->users = Auth::user();
            $this->dokterID = Karyawans::with('dokter')->where('user_id', $this->users->id)->first()->dokter->id;
            return $next($request);
        });
    }

    public function index()
    {
        $rekam = Rekam::today()->where('dokter_id', $this->dokterID)->ongoing()->orderBy('id','DESC')->first();
        return view('dokter.pemeriksaan', array(
            'title' => "Dashboard Administrator | MyKlinik v.1.0",
            'firstMenu' => 'pemeriksaan',
            'secondMenu' => 'pemeriksaan',
            'dataRekam' => $rekam
        ));
    }
}
