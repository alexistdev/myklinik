<?php
/*
 * Copyright (c) 2024.
 * Develop By: Alexsander Hendra Wijaya
 * Github: https://github.com/alexistdev
 * Phone : 0823-7140-8678
 * Email : Alexistdev@gmail.com
 */

namespace App\View\Components\Admint;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class JsLayoutAdmin extends Component
{

    public function __construct()
    {
        //
    }

    public function render(): View|Closure|string
    {
        return view('components.admint.js-layout-admin');
    }
}
