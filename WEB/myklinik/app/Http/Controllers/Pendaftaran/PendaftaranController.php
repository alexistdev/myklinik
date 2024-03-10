<?php
/*
 * Copyright (c) 2024.
 * Develop By: Alexsander Hendra Wijaya
 * Github: https://github.com/alexistdev
 * Phone : 0823-7140-8678
 * Email : Alexistdev@gmail.com
 */

namespace App\Http\Controllers\Pendaftaran;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pendaftaran\PasienRequest;
use App\Models\Pasien;
use App\Models\User;
use App\Services\Pendaftaran\PendaftaranService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class PendaftaranController extends Controller
{
    protected User $users;
    protected string $prefix;
    protected PendaftaranService $pendaftaranService;

    public function __construct(PendaftaranService $pendaftaranService)
    {
        $this->middleware(function ($request, $next) {
            $this->users = Auth::user();
            return $next($request);
        });
        $this->prefix = "AGTS-" . date("mY") . "-";
        $this->pendaftaranService = $pendaftaranService;

    }

    public function index(Request $request)
    {
        $dataPasien = "";
        if($request->get('pasien') != null){
            try{
                $pasien_id = decrypt($request->get('pasien'));
                $dataPasien = Pasien::findOrfail($pasien_id);
            }catch (\Exception $exception){
                abort('404','NOT FOUND');
            }
        }

        return view('front.pendaftaran', array(
            'title' => "Dashboard Administrator | MyKlinik v.1.0",
            'firstMenu' => 'pendaftaran',
            'secondMenu' => 'pendaftaran',
            'dataPasien' => $dataPasien
        ));
    }

    private function generateZero($totalData, $length, $lastId):string
    {
        $str = "0";
        for ($i = 0; $i < (($totalData - 1) - $length); $i++) {
            $str = $str . "0";
        }
        return $str . $lastId;
    }

    public function generateCode()
    {
        do {
            $totalData = 7;
            $lastPasien = Pasien::orderBy('id', 'desc')->first();
            if ($lastPasien != null) {
                $lastId = ((int)$lastPasien->id) + 1;
                $length = strlen($lastId);
                if ($length > 0 && $length <= $totalData) {
                    $finalCode = $this->generateZero($totalData,$length,$lastId);
                } else if($length > $totalData){
                    $finalCode = $this->generateZero($totalData+1,$length,$lastId);
                } else {
                    $finalCode = "00000001";
                }
            }
            $code = $this->prefix . $finalCode;
        } while (Pasien::where('kode_pasien', $code)->exists());
        return json_encode($code);
    }

    public function getDataPasien(Request $request)
    {
        if ($request->ajax()) {
            return $this->pendaftaranService->getDataPasien($request);
        }
        return null;
    }

    public function store(PasienRequest $request)
    {
        $request->validated();
        DB::beginTransaction();
        try {
            $cekUser = Pasien::where('kode_pasien',$request->kode_pasien)->first();
            if($cekUser != ""){
                $this->pendaftaranService->update($request, $cekUser->id);
            } else {
                $this->pendaftaranService->save($request);
            }
            DB::commit();
            return redirect(route('front.pendaftaran'))->with(['success' => "Pasien berhasil didaftarkan!"]);
        } catch (Exception $e) {
            DB::rollback();
            return redirect(route('front.pendaftaran'))->withErrors(['error' => $e->getMessage()]);
        }
    }


}
