<?php

namespace App\Services\Admin;

use App\Http\Requests\Admin\KaryawanRequest;
use App\Models\Karyawans;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class KaryawanServiceImpl implements KaryawanService
{
    public function index(Request $request)
    {
        $karyawan = User::with('karyawan','role')
            ->karyawan()
            ->orderBy('id', 'DESC')->get();
        return DataTables::of($karyawan)
            ->addIndexColumn()
            ->editColumn('name', function ($request) {
                return ucfirst($request->name);
            })
            ->editColumn('created_at', function ($request) {
                return $request->created_at->format('d-m-Y H:i:s');
            })
            ->editColumn('nip', function ($request) {
                return $request->karyawan->nip ?? "-";
            })
            ->editColumn('alamat', function ($request) {
                return $request->karyawan->alamat ?? "-";
            })
            ->editColumn('phone', function ($request) {
                return $request->karyawan->phone ?? "-";
            })
            ->editColumn('sex', function ($request) {
                return $request->karyawan->sex ?? "-";
            })
            ->editColumn('role', function ($request) {
                $str = "";
                if($request->role_id != null){
                    if($request->role_id == "3"){
                        $str = "BAG.PENDAFTARAN";
                    }else if($request->role_id == "4"){
                        $str = "DOKTER";
                    }else if($request->role_id == "5"){
                        $str = "STAFF APOTIK";
                    } else {
                        $str = "NA";
                    }
                }
                return $str;
            })
            ->addColumn('action', function ($row) {
                $id = encrypt($row->id);
                $url = route('adm.karyawan.edit',$id);
                $btn = "<a href=\"$url\"><button class=\"btn btn-sm btn-primary open-edit\"><i class=\"fas fa-edit\"></i> Edit</button></a>";
                $btn = $btn . " <a href=\"#\" class=\"btn btn-sm btn-danger ml-auto open-hapus\" data-id=\"$id\" data-bs-toggle=\"modal\" data-bs-target=\"#modalHapus\"><i class=\"fas fa-trash\"></i> Delete</i></a>";
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function save(KaryawanRequest $request)
    {
        $user = new User();
        $user->role_id = base64_decode($request->role_id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->nip);
        $user->save();
        $idUser = $user->id;
        $this->save_karyawan($request,$idUser);
    }

    private function save_karyawan($karyawans, int $userId):int
    {
        $insert = new Karyawans();
        $insert->user_id = $userId;
        $insert->nip = $karyawans->nip;
        $insert->alamat = $karyawans->alamat;
        $insert->phone = $karyawans->phone;
        $insert->sex = $karyawans->sex;
        $insert->tanggal_bergabung = date("Y-m-d");
        $insert->status = 1;
        $insert->save();
        return $insert->id;
     }

    public function update(KaryawanRequest $request)
    {
        $user = User::findOrFail(decrypt($request->user_id));
        $user->where('id',$user->id)->update([
            'email' => $request->email,
            'name' => $request->name,
            'role_id' => base64_decode($request->role_id)
        ]);

        Karyawans::where('user_id',$user->id)->update([
           'nip' => $request->nip,
           'alamat' => $request->alamat,
           'phone' => $request->phone,
           'sex' => $request->sex
        ]);
    }

    public function delete(string $id)
    {
        $userId = decrypt($id);
        $user = User::find($userId);
        if(!$user){
            abort('404', 'NOT FOUND');
        }
        $user->delete();
    }


}
