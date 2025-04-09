<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AccountantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $allowedRoles = ['1', '2', '3']; 
            if (in_array(Auth::user()->role_id, $allowedRoles)) {
                return $next($request);
            } else {
                return redirect('login')->with('status', 'Access Denied! You do not have the required permissions.');
            }
        } else {
            return redirect('login')->with('status', 'Please Login First');
        }
    }
    
    

}
