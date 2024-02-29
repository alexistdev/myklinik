<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\KaryawanRequest;
use App\Models\Role;
use App\Models\User;
use App\Services\Admin\KaryawanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;

class KaryawanController extends Controller
{
    /**
     * Author: AlexistDev
     * Email: Alexistdev@gmail.com
     * Phone: 082371408678
     * Github: https://github.com/alexistdev
     */
    protected User $users;
    protected KaryawanService $karyawanService;

    public function __construct(KaryawanService $karyawanService)
    {
        $this->middleware(function ($request, $next) {
            $this->users = Auth::user();
            return $next($request);
        });
        $this->karyawanService = $karyawanService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->karyawanService->index($request);
        }

        return view('admin.karyawan.index', array(
            'title' => "Dashboard Administrator | MyKlinik v.1.0",
            'firstMenu' => 'karyawan',
            'secondMenu' => 'karyawan',
        ));
    }

    public function store(KaryawanRequest $request)
    {
        $request->validated();
        DB::beginTransaction();
        try {
            $this->karyawanService->save($request);
            DB::commit();
            return redirect(route('adm.karyawan'))->with(['success' => "Data Karyawan berhasil ditambahkan!"]);
        } catch (Exception $e) {
            DB::rollback();
            return redirect(route('adm.karyawan'))->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function create()
    {
        $role = Role::karyawan()->get();
        return view('admin.karyawan.add', array(
            'title' => "Dashboard Administrator | MyKlinik v.1.0",
            'firstMenu' => 'karyawan',
            'secondMenu' => 'karyawan',
            'dataRole' => $role
        ));
    }

    public function edit(string $id = null)
    {
        if ($id != null) {
            try{
                $user = User::with('karyawan')->findOrFail(decrypt($id));
                $role = Role::karyawan()->get();
                return view('admin.karyawan.edit', array(
                    'title' => "Dashboard Administrator | MyKlinik v.1.0",
                    'firstMenu' => 'karyawan',
                    'secondMenu' => 'karyawan',
                    'dataRole' => $role,
                    'dataKaryawan' => $user
                ));
            }catch (Exception $e){
                abort('404',"NOT FOUND");
            }
        }
        abort('404',"NOT FOUND");
    }

    public function update(KaryawanRequest $request)
    {
        $request->validated();
        DB::beginTransaction();
        try {
            $this->karyawanService->update($request);
            DB::commit();
            return redirect(route('adm.karyawan.edit',$request->user_id))->with(['success' => "Data Karyawan berhasil diperbaharui!"]);
        } catch (Exception $e) {
            DB::rollback();
            return redirect(route('adm.karyawan'))->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy(KaryawanRequest $request)
    {
        $request->validated();
        DB::beginTransaction();
        try {
            $this->karyawanService->delete($request->user_id);
            DB::commit();
            return redirect(route('adm.karyawan'))->with(['delete' => "Data Karyawan berhasil dihapus!"]);
        } catch (Exception $e) {
            DB::rollback();
            return redirect(route('adm.karyawan'))->withErrors(['error' => $e->getMessage()]);
        }
    }
}
