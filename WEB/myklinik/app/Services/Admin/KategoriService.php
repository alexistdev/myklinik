<?php

namespace App\Services\Admin;

use Illuminate\Http\Request;

interface KategoriService
{
    /**
         * Author: AlexistDev
         * Email: Alexistdev@gmail.com
         * Phone: 082371408678
         * Github: https://github.com/alexistdev
         */

    public function index(Request $request);

    public function save(Request $request):void;

    public function update(Request $request):void;

    public function delete(int $id):void;
}
