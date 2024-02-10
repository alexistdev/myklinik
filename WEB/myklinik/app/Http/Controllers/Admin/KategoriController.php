<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori_obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class KategoriController extends Controller
{
    protected $users;


    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->users = Auth::user();
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $kategori = Kategori_obat::orderBy('name','ASC')->get();
            return DataTables::of($kategori)
                ->addIndexColumn()
                ->editColumn('name', function ($request) {
                    return ucfirst($request->name);
                })
                ->editColumn('created_at', function ($request) {
                    return $request->created_at->format('d-m-Y H:i:s');
                })
                ->addColumn('action', function ($row) {
//                    $edit = route('adm.guru.edit', base64_encode($row->id));
//                    $btn = "<a href=\"$edit\"><button class=\"btn btn-sm btn-primary\"><i class=\"fas fa-edit\"></i> Edit</button></a>";
//                    $btn = $btn . " <a href=\"#\" class=\"btn btn-sm btn-danger ml-auto open-hapus\" data-id=\"$row->user_id\" data-bs-toggle=\"modal\" data-bs-target=\"#hapusModal\"><i class=\"fas fa-trash\"></i> Delete</i></a>";
                    return "-";
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.kategori', array(
            'title' => "Dashboard Administrator | MyKlinik v.1.0",
            'firstMenu' => 'dashboard',
            'secondMenu' => 'dashboard',
        ));
    }
}
