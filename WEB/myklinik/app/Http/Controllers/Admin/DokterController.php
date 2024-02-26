<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Admin\KaryawanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DokterController extends Controller
{
    /**
         * Author: AlexistDev
         * Email: Alexistdev@gmail.com
         * Phone: 082371408678
         * Github: https://github.com/alexistdev
         */

    protected $users;
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
}
