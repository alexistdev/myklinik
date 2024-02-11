<?php

namespace App\Services\Admin;

use App\Http\Requests\Admin\ObatRequest;
use App\Models\Golongan_obat;
use App\Models\Kategori_obat;
use App\Models\Obat;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ObatServiceImpl implements ObatService
{
    /**
         * Author: AlexistDev
         * Email: Alexistdev@gmail.com
         * Phone: 082371408678
         * Github: https://github.com/alexistdev
         */

    public function index(Request $request)
    {
        $obat = Obat::orderBy('id', 'DESC')->get();
        return DataTables::of($obat)
            ->addIndexColumn()
            ->editColumn('name', function ($request) {
                return ucfirst($request->name);
            })
            ->editColumn('created_at', function ($request) {
                return $request->created_at->format('d-m-Y H:i:s');
            })
            ->addColumn('action', function ($row) {
                $id = base64_encode($row->id);
                $btn = "<button class=\"btn btn-sm btn-primary open-edit\" data-name =\" $row->name \" data-id=\"$id\"data-bs-toggle=\"modal\" data-bs-target=\"#modalEdit\"><i class=\"fas fa-edit\"></i> Edit</button>";
                $btn = $btn . " <a href=\"#\" class=\"btn btn-sm btn-danger ml-auto open-hapus\" data-id=\"$id\" data-bs-toggle=\"modal\" data-bs-target=\"#modalHapus\"><i class=\"fas fa-trash\"></i> Delete</i></a>";
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function save(ObatRequest $request): void
    {
        $obat = new Obat();
        $kategori = Kategori_obat::findOrFail(base64_decode($request->kategori_id));
        $golongan = Golongan_obat::findOrFail(base64_decode($request->golongan_id));
        $obat->kategoriobat_id = $kategori->id;
        $obat->golonganobat_id = $golongan->id;
        $obat->name = $request->name;
        $obat->type = $request->type;
        $obat->price = $request->price;
        $obat->stock = $request->stock;
        $obat->save();
    }


}
