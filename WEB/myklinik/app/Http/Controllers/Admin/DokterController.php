<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DokterRequest;
use App\Models\Poliklinik;
use Exception;
use App\Models\User;
use App\Services\Admin\KaryawanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DokterController extends Controller
{
    /**
         * Author: AlexistDev
         * Email: Alexistdev@gmail.com
         * Phone: 082371408678
         * Github: https://github.com/alexistdev
         */

    protected User $users;
    protected KaryawanService $karyawanService;

    public function __construct(KaryawanService $karyawanService)
    {
        $this->middleware(function ($request, $next) {
            $this->users = Auth::user();
            return $next($request);
        });
        $this->karyawanService = $karyawanService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->karyawanService->index_dokter($request);
        }

        return view('admin.dokter.index', array(
            'title' => "Dashboard Administrator | MyKlinik v.1.0",
            'firstMenu' => 'karyawan',
            'secondMenu' => 'dokter',
        ));
    }

    public function create()
    {
        $poliklinik = Poliklinik::orderBy('name','asc')->get();
        return view('admin.dokter.add', array(
            'title' => "Dashboard Administrator | MyKlinik v.1.0",
            'firstMenu' => 'karyawan',
            'secondMenu' => 'dokter',
            'dataPoliklinik' => $poliklinik
        ));
    }

    public function store(DokterRequest $request)
    {
        $request->validated();
        DB::beginTransaction();
        try {
            $this->karyawanService->save_dokter($request);
            DB::commit();
            return redirect(route('adm.dokter'))->with(['success' => "Data Dokter berhasil ditambahkan!"]);
        } catch (Exception $e) {
            DB::rollback();
            return redirect(route('adm.dokter'))->withErrors(['error' => $e->getMessage()]);
        }
    }
}
