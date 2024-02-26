<?php

namespace App\Services\Admin;

use App\Http\Requests\Admin\KaryawanRequest;
use Illuminate\Http\Request;

interface KaryawanService
{
    /**
         * Author: AlexistDev
         * Email: Alexistdev@gmail.com
         * Phone: 082371408678
         * Github: https://github.com/alexistdev
         */
    public function index(Request $request);

    public function save(KaryawanRequest $request);

    public function update(KaryawanRequest $request);

    public function delete(string $request);

    /**
     *  Dokter
     */
    public function index_dokter(Request $request);
}
