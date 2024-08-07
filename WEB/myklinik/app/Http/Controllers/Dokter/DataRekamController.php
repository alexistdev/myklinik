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
use App\Models\Pasien;
use App\Models\Rekam;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;

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
        $rekam = Rekam::with('pasien', 'antrian')->today()->where('dokter_id', $this->dokterID)->ongoing()->get()->sortBy('antrian');
        return view('dokter.pemeriksaan', array(
            'title' => "Dashboard Administrator | MyKlinik v.1.0",
            'firstMenu' => 'pemeriksaan',
            'secondMenu' => 'pemeriksaan',
            'dataRekam' => $rekam
        ));
    }

    public function detail_pasien($id)
    {
        try {
            $idPasien = base64_decode($id);
            $pasien = Pasien::findOrFail($idPasien);
            return view('dokter.detailpasien', array(
                'title' => "Dashboard Administrator | MyKlinik v.1.0",
                'firstMenu' => 'pemeriksaan',
                'secondMenu' => 'pemeriksaan',
                'dataPasien' => $pasien
            ));
        } catch (Exception $e) {
            abort(404);
        }

    }

    public function proses()
    {
        try {
            $rekam = Rekam::with('pasien')->where('dokter_id', $this->dokterID)->today()->ongoing()->orderBy('id', 'ASC')->get();
            $dataPasien = $rekam->first();
            $cekOngoing = $rekam->where('status', '1');
            if ($cekOngoing->count() > 0) {
                $dataPasien =  $cekOngoing->first();
            }
            $rekam->first()->pushStatus("1");
//            return $dataPasien;
            return view('dokter.detailpemeriksaan', array(
                'title' => "Dashboard Administrator | MyKlinik v.1.0",
                'firstMenu' => 'pemeriksaan',
                'secondMenu' => 'pemeriksaan',
                'dataPasien' => $dataPasien
            ));
        } catch (Exception $e) {
            abort(404);
        }
    }
}
