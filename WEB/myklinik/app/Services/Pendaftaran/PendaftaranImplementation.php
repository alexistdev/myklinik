<?php
/*
 * Copyright (c) 2024.
 * Develop By: Alexsander Hendra Wijaya
 * Github: https://github.com/alexistdev
 * Phone : 0823-7140-8678
 * Email : Alexistdev@gmail.com
 */

namespace App\Services\Pendaftaran;

use App\Http\Requests\Pendaftaran\PasienRequest;
use App\Models\Pasien;
use App\Models\Rekam;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PendaftaranImplementation implements PendaftaranService
{
    public function save(PasienRequest $request): void
    {
        $pasien = new Pasien();
        $pasien->kode_pasien = $request->kode_pasien;
        $pasien->nama_lengkap = $request->nama_lengkap;
        $pasien->tanggal_lahir = $request->tanggal_lahir;
        $pasien->tempat_lahir = $request->tempat_lahir;
        $pasien->sex = $request->sex;
        $pasien->agama = $request->agama;
        $pasien->pendidikan = $request->pendidikan;
        $pasien->phone = $request->phone;
        $pasien->gol_darah = $request->golongan_darah;
        $pasien->pekerjaan = $request->pekerjaan;
        $pasien->alamat = $request->alamat;
        $pasien->save();
    }

    public function update(PasienRequest $request, int $id): void
    {
        Pasien::where('id',$id)->update([
           'nama_lengkap' => $request->nama_lengkap,
           'tanggal_lahir' => $request->tanggal_lahir,
           'tempat_lahir' => $request->tempat_lahir,
           'sex' => $request->sex,
           'agama' => $request->agama,
           'pendidikan' => $request->pendidikan,
           'phone' => $request->phone,
           'gol_darah' => $request->golongan_darah,
           'pekerjaan' => $request->pekerjaan,
           'alamat' => $request->alamat,
        ]);
    }

    private function create_rekam($request,$idPasien,$createdBy):void
    {
        $rekam = new Rekam();
        $rekam->pasien_id = $idPasien;
        $rekam->dokter_id = base64_decode($request->dokter_id);
        $rekam->kode_rekam = $this->generateCode();
        $rekam->tekanan_darah = $request->tekanan_darah;
        $rekam->rate = $request->rate;
        $rekam->suhu_badan = $request->suhu_badan;
        $rekam->berat_badan = $request->berat_badan;
        $rekam->tinggi_badan = $request->tinggi_badan;
        $rekam->keluhan_utama = $request->keluhan_utama;
        $rekam->created_by = $createdBy;
        $rekam->status = 0;
        $rekam->save();
    }

    public function generateCode():string
    {
        do {
            $totalData = 7;
            $prefix = "AGTS-" . date("mY") . "-";
            $lastPasien = Rekam::orderBy('id', 'desc')->first();
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
            $code = $prefix . $finalCode;
        } while (Pasien::where('kode_pasien', $code)->exists());
        return $code;
    }

    private function generateZero($totalData, $length, $lastId):string
    {
        $str = "0";
        for ($i = 0; $i < (($totalData - 1) - $length); $i++) {
            $str = $str . "0";
        }
        return $str . $lastId;
    }



    public function getDataPasien(Request $request)
    {
        $pasien = Pasien::orderBy('nama_lengkap', 'asc')->get();
        return DataTables::of($pasien)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $id = encrypt($row->id);
                $btn = "<input type=\"checkbox\"  class=\"open-selected\" data-id=\"$id\">";
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }


}
