<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->user()) {
            return redirect()->route('index');
            // break;
        } elseif(auth()->user()->status != 1) {
            Auth::logout();
            return redirect()->route('index')->with('error', 'Your account is not verified. Please verify your account first.');
            // break;
        }
        return $next($request);
        
        // return $response->header('Cache-Control','nocache, no-store, max-age=0, must-revalidate')->header('Pragma','no-cache');

    }   
    
}
