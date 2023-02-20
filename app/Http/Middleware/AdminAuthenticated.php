<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if( Auth::check() )
        {
            /** @var User $user */
            $user = Auth::user();

            // if users is not admin take him to his dashboard
//            if ( $users->hasRole('users') ) {
//                return redirect(route('home.index'));
//            }
//
//            // allow admin to proceed with request
//            else if ( $users->hasRole('admin') ) {
//                return $next($request);
//            }
//
//            else if ( $users->hasRole('super_admin') ) {
//                return $next($request);
//            }
        }

        abort(403);  // permission denied error
    }
}
