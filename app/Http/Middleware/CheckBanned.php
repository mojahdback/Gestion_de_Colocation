<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckBanned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if(Auth::check()){

           $user = Auth::user();

           if($user->is_banned ){

                Auth::logout();

                return redirect('/login')->withErrors([

                    'email' => 'Your account is blocked'

                ]);

           }
        }
        return $next($request);
    }
}
