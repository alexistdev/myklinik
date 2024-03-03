<?php
/*
 * Copyright (c) 2024.
 * Develop By: Alexsander Hendra Wijaya
 * Github: https://github.com/alexistdev
 * Phone : 0823-7140-8678
 * Email : Alexistdev@gmail.com
 */

namespace App\Services\Admin;

use Illuminate\Http\Request;

interface KategoriService
{

    public function index(Request $request);

    public function save(Request $request):void;

    public function update(Request $request):void;

    public function delete(int $id):void;
}
