<?php

namespace App\Services\Admin;

use App\Http\Requests\Admin\ObatRequest;
use Illuminate\Http\Request;

interface ObatService
{
    /**
         * Author: AlexistDev
         * Email: Alexistdev@gmail.com
         * Phone: 082371408678
         * Github: https://github.com/alexistdev
         */

    public function index(Request $request);

    public function save(ObatRequest $request):void;

    public function update(ObatRequest $request):void;

    public function delete(string $id):void;
}
