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
