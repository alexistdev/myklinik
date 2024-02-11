<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ObatRequest;
use App\Models\Golongan_obat;
use App\Models\Kategori_obat;
use App\Services\Admin\ObatService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ObatController extends Controller
{
    /**
         * Author: AlexistDev
         * Email: Alexistdev@gmail.com
         * Phone: 082371408678
         * Github: https://github.com/alexistdev
         */

    protected $users;
    protected ObatService $obatService;

    public function __construct(ObatService $obatService)
    {
        $this->middleware(function ($request, $next) {
            $this->users = Auth::user();
            return $next($request);
        });
        $this->obatService = $obatService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->obatService->index($request);
        }

        return view('admin.obat', array(
            'title' => "Dashboard Administrator | MyKlinik v.1.0",
            'firstMenu' => 'myData',
            'secondMenu' => 'obat',
        ));
    }

    public function create()
    {
        $kategori = Kategori_obat::orderBy('name','ASC')->get();
        $golongan = Golongan_obat::orderBy('name','ASC')->get();
        return view('admin.addobat', array(
            'title' => "Dashboard Administrator | MyKlinik v.1.0",
            'firstMenu' => 'myData',
            'secondMenu' => 'obat',
            'optionKategori' => $kategori,
            'optionGolongan' => $golongan,
        ));
    }

    public function store(ObatRequest $request)
    {
        $request->validated();
        DB::beginTransaction();
        try{
            $this->obatService->save($request);
            DB::commit();
            return redirect(route('adm.obat'))->with(['success' => "Data Obat berhasil ditambahkan!"]);
        }catch (Exception $e){
            DB::rollback();
            return redirect(route('adm.obat'))->withErrors(['error' => $e->getMessage()]);
        }
    }
}
