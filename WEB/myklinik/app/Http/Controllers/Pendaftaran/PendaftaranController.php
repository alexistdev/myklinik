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
use App\Models\Poliklinik;
use App\Models\Rekam;
use App\Models\User;
use App\Services\Pendaftaran\PendaftaranService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $poliklinik =Poliklinik::with('dokter')->orderBy('name','asc')->get();
        $filteredPoliklinik = $poliklinik->filter(function ($poliklinik) {
            return $poliklinik->dokter != null;
        });
        $rekam = Rekam::with('antrian')->today()->get();
        $sisa =  $rekam->where('status',0)->count();
        $onProses = $rekam->where('status', '=',"1")->sortBy('id')->first();

        return view('front.pendaftaran', array(
            'title' => "Dashboard Administrator | MyKlinik v.1.0",
            'firstMenu' => 'pendaftaran',
            'secondMenu' => 'pendaftaran',
            'dataPasien' => $dataPasien,
            'dataPoli' => $filteredPoliklinik,
            'totalAntrian' => $sisa,
            'onProsesAntrian' => $onProses->antrian->nomor ?? '0',
        ));
    }

    public function generateCode()
    {
        $next = ((int) (Pasien::withTrashed()->max('id') ?? 0)) + 1;
        do {
            $code = $this->prefix . str_pad((string) $next, 7, "0", STR_PAD_LEFT);
            $next++;
        } while (Pasien::withTrashed()->where('kode_pasien', $code)->exists());
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
                $this->pendaftaranService->update($request, $cekUser->id,$this->users->name ?? "");
            } else {
                $this->pendaftaranService->save($request,$this->users->name ?? "");
            }
            DB::commit();
            return redirect(route('front.pendaftaran'))->with(['success' => "Pasien berhasil didaftarkan!"]);
        } catch (Exception $e) {
            DB::rollback();
            return redirect(route('front.pendaftaran'))->withErrors(['error' => $e->getMessage()]);
        }
    }


}
