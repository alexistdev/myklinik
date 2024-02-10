<?php

namespace App\View\Components\Admint;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class JsLayoutAdmin extends Component
{
    /**
         * Author: AlexistDev
         * Email: Alexistdev@gmail.com
         * Phone: 082371408678
         * Github: https://github.com/alexistdev
         */

    public function __construct()
    {
        //
    }

    public function render(): View|Closure|string
    {
        return view('components.admint.js-layout-admin');
    }
}
