<?php
/*
 * Copyright (c) 2024.
 * Develop By: Alexsander Hendra Wijaya
 * Github: https://github.com/alexistdev
 * Phone : 0823-7140-8678
 * Email : Alexistdev@gmail.com
 */

namespace App\Services\Pendaftaran;

use App\Http\Requests\Dokter\PeriksaRequest;
use App\Http\Requests\Pendaftaran\PasienRequest;
use App\Models\Antrian;
use App\Models\Pasien;
use App\Models\Rekam;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PendaftaranImplementation implements PendaftaranService
{
    public function save(PasienRequest $request,string $createdBy): void
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
        $id = $pasien->id;
        $idRekam = $this->create_rekam($request,$id,$createdBy);
        $this->createAntrian($idRekam);
    }

    public function update(PasienRequest $request, int $id, string $createdBy): void
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

        $idRekam =  $this->create_rekam($request,$id,$createdBy);
        $this->createAntrian($idRekam);
    }

    private function create_rekam($request,$idPasien,$createdBy):int
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
        return $rekam->id;
    }

    private function createAntrian($idRekam):void
    {
        $antrian = new Antrian();
        $antrian->rekam_id = $idRekam;
        $antrian->save();
    }

    public function generateCode():string
    {
        $prefix = "RKM-" . date("mY") . "-";
        $next = ((int) (Rekam::withTrashed()->max('id') ?? 0)) + 1;
        do {
            $code = $prefix . str_pad((string) $next, 8, "0", STR_PAD_LEFT);
            $next++;
        } while (Rekam::withTrashed()->where('kode_rekam', $code)->exists());
        return $code;
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

    public function save_pemeriksaan(PeriksaRequest $request): void
    {
        $rekam = Rekam::findOrFail(base64_decode($request->rekam_id));
        $rekam->update([
            'status' => '2',
            'diagnosis' => $request->diagnosa,
            'deskripsi_tindakan' => $request->deskripsi_tindakan,
        ]);
    }


}
