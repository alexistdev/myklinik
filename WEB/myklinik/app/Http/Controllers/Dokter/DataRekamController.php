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
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DataRekamController extends Controller
{
    protected User $users;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->users = Auth::user();
            return $next($request);
        });
    }

    public function index(Request $request)
    {
//        if ($request->ajax()) {
////            return $this->golonganService->index($request);
//        }

        return view('dokter.pemeriksaan', array(
            'title' => "Dashboard Administrator | MyKlinik v.1.0",
            'firstMenu' => 'pemeriksaan',
            'secondMenu' => 'pemeriksaan',
        ));
    }
}
