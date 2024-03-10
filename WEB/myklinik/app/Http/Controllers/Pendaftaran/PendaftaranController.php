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
use App\Models\Pasien;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class PendaftaranController extends Controller
{
    protected User $users;
    protected string $prefix;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->users = Auth::user();
            return $next($request);
        });
        $this->prefix = "AGTS-".date("mY")."-";

    }

    public function index()
    {
        return view('front.pendaftaran', array(
            'title' => "Dashboard Administrator | MyKlinik v.1.0",
            'firstMenu' => 'pendaftaran',
            'secondMenu' => 'pendaftaran',
        ));
    }

    public function generateCode()
    {
        do {
            $totalData = 8;
            $lastId = "00000001";
            $lastPasien = Pasien::orderBy('id','desc')->first();
            if($lastPasien != null){
                $lastId = ((int) $lastPasien->id) + 1;
                $length = strlen($lastId);
                if($length > 0 && $length <= 8){
                    $str = "0";
                    for($i=0; $i < (($totalData-1)-$length); $i++){
                        $str = $str."0";
                    }
                    $lastId = $str.$lastId;
                }
            }
            $code = $this->prefix. $lastId;
        } while (Pasien::where('kode_pasien', $code)->exists());
        return json_encode($code);
    }

    public function getDataPasien(Request $request)
    {
        if ($request->ajax()) {
            $pasien = Pasien::orderBy('nama_lengkap','asc')->get();
            return DataTables::of($pasien)
                ->addIndexColumn()
//                ->editColumn('sex', function ($request) {
//                    return $request->karyawan->sex ?? "-";
//                })

                ->addColumn('action', function ($row) {
//                    $id = encrypt($row->id);
//                    $url = route('adm.dokter.edit',$id);
//                    $btn = "<a href=\"$url\"><button class=\"btn btn-sm btn-primary open-edit\"><i class=\"fas fa-edit\"></i> Edit</button></a>";
//                    $btn = $btn . " <a href=\"#\" class=\"btn btn-sm btn-danger ml-auto open-hapus\" data-id=\"$id\" data-bs-toggle=\"modal\" data-bs-target=\"#modalHapus\"><i class=\"fas fa-trash\"></i> Delete</i></a>";
//                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function store()
    {

    }


}
