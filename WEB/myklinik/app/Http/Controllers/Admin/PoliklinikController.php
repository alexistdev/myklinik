<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PoliklinikRequest;
use App\Services\Admin\PoliklinikService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PoliklinikController extends Controller
{
    /**
     * Author: AlexistDev
     * Email: Alexistdev@gmail.com
     * Phone: 082371408678
     * Github: https://github.com/alexistdev
     */

    protected $users;
    protected PoliklinikService $poliklinikService;

    public function __construct(PoliklinikService $poliklinikService)
    {
        $this->middleware(function ($request, $next) {
            $this->users = Auth::user();
            return $next($request);
        });
        $this->poliklinikService = $poliklinikService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->poliklinikService->index($request);
        }

        return view('admin.poliklinik', array(
            'title' => "Dashboard Administrator | MyKlinik v.1.0",
            'firstMenu' => 'poliklinik',
            'secondMenu' => 'poliklinik',
        ));
    }

    public function store(PoliklinikRequest $request)
    {
        $request->validated();
        DB::beginTransaction();
        try {
            $this->poliklinikService->save($request);
            DB::commit();
            return redirect(route('adm.poli'))->with(['success' => "Data Poliklinik berhasil ditambahkan!"]);
        } catch (Exception $e) {
            DB::rollback();
            return redirect(route('adm.poli'))->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function update(PoliklinikRequest $request)
    {
        $request->validated();
        DB::beginTransaction();
        try {
            $this->poliklinikService->update($request);
            DB::commit();
            return redirect(route('adm.poli'))->with(['success' => "Data Poliklinik berhasil diperbaharui!"]);
        } catch (Exception $e) {
            DB::rollback();
            return redirect(route('adm.poli'))->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy(PoliklinikRequest $request)
    {
        $request->validated();
        DB::beginTransaction();
        try {
            $id = base64_decode($request->poliklinik_id);
            $this->poliklinikService->delete($id);
            DB::commit();
            return redirect(route('adm.poli'))->with(['delete' => "Data Poliklinik berhasil dihapus!"]);
        } catch (Exception $e) {
            DB::rollback();
            abort('404',"NOT FOUND");
        }
    }
}
