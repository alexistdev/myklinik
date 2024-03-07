<?php
/*
 * Copyright (c) 2024.
 * Develop By: Alexsander Hendra Wijaya
 * Github: https://github.com/alexistdev
 * Phone : 0823-7140-8678
 * Email : Alexistdev@gmail.com
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CekRole
{
    /**
         * Author: AlexistDev
         * Email: Alexistdev@gmail.com
         * Phone: 082371408678
         * Github: https://github.com/alexistdev
         */


    public function handle(Request $request, Closure $next): Response
    {
        $roles = $this->CekRoute($request->route());
        if ($request->user()->hasRole($roles) || !$roles) {
            return $next($request);
        }
        return abort(404, 'NOT FOUND');
    }

    private function CekRoute($route)
    {
        $action = $route->getAction();
        return isset($action['roles']) ? $action['roles'] : null;
    }
}
