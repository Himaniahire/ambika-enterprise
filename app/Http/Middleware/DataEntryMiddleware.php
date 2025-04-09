<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class DataEntryMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check())
        {
            if([Auth::user()->role_id == '3',Auth::user()->role_id == '1'])
            {
                return $next($request);
            }
            else
            {
                return redirect('login')->with('status','Access Denied! as you are not as admin');
            }
        }
        else
        {
            return redirect('login')->with('status','Please Login First');
        }
    }
}
