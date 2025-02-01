<?php
/*
 * Copyright (c) 2024.
 * Develop By: Alexsander Hendra Wijaya
 * Github: https://github.com/alexistdev
 * Phone : 0823-7140-8678
 * Email : Alexistdev@gmail.com
 */

namespace App\Services\Admin;

use App\Http\Requests\Admin\ObatRequest;
use App\Models\Golongan_obat;
use App\Models\Kategori_obat;
use App\Models\Obat;
use App\Models\Produsen;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ObatServiceImpl implements ObatService
{

    public function index(Request $request)
    {
        $obat = Obat::with('golongan')->orderBy('id', 'DESC')->get();
        return DataTables::of($obat)
            ->addIndexColumn()
            ->editColumn('name', function ($request) {
                return ucfirst($request->name);
            })
            ->editColumn('created_at', function ($request) {
                return $request->created_at->format('d-m-Y H:i:s');
            })
            ->editColumn('golongan', function ($request) {
                return strtoupper($request->golongan->name);
            })
            ->editColumn('kategori', function ($request) {
                return strtoupper($request->kategori->name);
            })
            ->editColumn('code', function ($request) {
                return strtoupper($request->code);
            })
            ->addColumn('action', function ($row) {
                $id = encrypt($row->id);
                $idBase64 = base64_encode($row->id);
                $url = route('adm.obat.edit',$id);
                $btn = "<a href=\"$url\"><button class=\"btn btn-sm btn-primary\"><i class=\"fas fa-edit\"></i> Edit</button></a>";
                $btn = $btn . " <a href=\"#\" class=\"btn btn-sm btn-danger ml-auto open-hapus\" data-id=\"$idBase64\" data-bs-toggle=\"modal\" data-bs-target=\"#modalHapus\"><i class=\"fas fa-trash\"></i> Delete</i></a>";
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
        $produsen = Produsen::findOrFail(base64_decode($request->produsen_id));
        $obat->kategoriobat_id = $kategori->id;
        $obat->golonganobat_id = $golongan->id;
        $obat->produsen_id = $produsen->id;
        $obat->name = $request->name;
        $obat->type = $request->type;
        $obat->price = $request->price;
        $obat->stock = $request->stock;
        $obat->save();
    }

    public function update(ObatRequest $request): void
    {
        $obat = Obat::findOrFail(decrypt($request->obat_id));
        $kategori = Kategori_obat::findOrFail(base64_decode($request->kategori_id));
        $golongan = Golongan_obat::findOrFail(base64_decode($request->golongan_id));
        $produsen = Produsen::findOrFail(base64_decode($request->produsen_id));
        Obat::where('id',$obat->id)->update([
            'kategoriobat_id' => $kategori->id,
            'golonganobat_id' => $golongan->id,
            'produsen_id' => $produsen->id,
            'name' => $request->name,
            'type' => $request->type,
            'price' => $request->price,
            'stock' => $request->stock
        ]);
    }

    public function delete(string $id): void
    {
        $obat = Obat::findOrFail($id);
        Obat::where('id',$obat->id)->delete();
    }


}
