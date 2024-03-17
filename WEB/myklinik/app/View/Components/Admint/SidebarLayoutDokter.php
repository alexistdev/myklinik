<?php

/******************************************************************************
 *                                                                            *
 *  * Copyright (c) 2024.                                                     *
 *  * Develop By: Alexsander Hendra Wijaya                                    *
 *  * Github: https://github.com/alexistdev                                   *
 *  * Phone : 0823-7140-8678                                                  *
 *  * Email : Alexistdev@gmail.com                                            *
 *                                                                            *
 ******************************************************************************/

namespace App\View\Components\Admint;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SidebarLayoutDokter extends Component
{
    public string $firstMenu;
    public string $secondMenu;
    public function __construct(string $firstMenu, string $secondMenu)
    {
        $this->firstMenu = $firstMenu;
        $this->secondMenu = $secondMenu;
    }

    public function render(): View|Closure|string
    {
        return view('components.admint.sidebar-layout-dokter');
    }
}
