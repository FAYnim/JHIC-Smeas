<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SpmbAuthMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! session()->has('spmb_nisn')) {
            return redirect()->route('spmb.index');
        }

        return $next($request);
    }
}
