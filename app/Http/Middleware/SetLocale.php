<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use  App;
use  Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $session = Session::get('lang') ?Session::get('lang'): config('app.locale');
        $request->session()->put('lang', $session);
        App::setLocale($session);
        return $next($request);
    }
}

