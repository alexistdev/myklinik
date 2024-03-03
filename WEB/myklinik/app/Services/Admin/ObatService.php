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
use Illuminate\Http\Request;

interface ObatService
{

    public function index(Request $request);

    public function save(ObatRequest $request):void;

    public function update(ObatRequest $request):void;

    public function delete(string $id):void;
}
