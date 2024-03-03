<?php
/*
 * Copyright (c) 2024.
 * Develop By: Alexsander Hendra Wijaya
 * Github: https://github.com/alexistdev
 * Phone : 0823-7140-8678
 * Email : Alexistdev@gmail.com
 */

namespace App\Services\Admin;

use App\Http\Requests\Admin\PoliklinikRequest;
use Illuminate\Http\Request;

interface PoliklinikService
{

    public function index(Request $request);

    public function save(PoliklinikRequest $request):void;

    public function update(PoliklinikRequest $request):void;

    public function delete(string $id):void;

}
