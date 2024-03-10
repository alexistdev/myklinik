<?php
/*
 * Copyright (c) 2024.
 * Develop By: Alexsander Hendra Wijaya
 * Github: https://github.com/alexistdev
 * Phone : 0823-7140-8678
 * Email : Alexistdev@gmail.com
 */

namespace App\Services\Pendaftaran;

use App\Http\Requests\Pendaftaran\PasienRequest;
use Illuminate\Http\Request;

interface PendaftaranService
{
    public function save(PasienRequest $request):void;

    public function update(PasienRequest $request, int $id):void;

    public function getDataPasien(Request $request);
}
