<?php

namespace App\Services\Admin;

use App\Http\Requests\Admin\GolonganRequest;
use Illuminate\Http\Request;

interface GolonganService
{
    /**
         * Author: AlexistDev
         * Email: Alexistdev@gmail.com
         * Phone: 082371408678
         * Github: https://github.com/alexistdev
         */

    public function index(Request $request);

    public function save(GolonganRequest $request):void;

    public function update(GolonganRequest $request):void;

    public function delete(int $id):void;

}
