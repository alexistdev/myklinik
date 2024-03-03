<?php
/*
 * Copyright (c) 2024.
 * Develop By: Alexsander Hendra Wijaya
 * Github: https://github.com/alexistdev
 * Phone : 0823-7140-8678
 * Email : Alexistdev@gmail.com
 */

namespace App\Services\Admin;

use App\Http\Requests\Admin\DokterRequest;
use App\Http\Requests\Admin\KaryawanRequest;
use Illuminate\Http\Request;

interface KaryawanService
{

    public function index(Request $request);

    public function save(KaryawanRequest $request);

    public function update(KaryawanRequest $request);

    public function delete(string $request);

    /**
     *  Dokter
     */
    public function index_dokter(Request $request);

    public function save_dokter(DokterRequest $request);

    public function update_dokter(DokterRequest $request);


}
