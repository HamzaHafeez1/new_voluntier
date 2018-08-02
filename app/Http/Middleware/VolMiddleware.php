<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class VolMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check() && $request->route()->getName() == "view-voluntier-profile") {
			return $next($request);
		}
        elseif(Auth::check() && Auth::user()->user_role == 'volunteer'){
            return $next($request);
        }
        else{
            return Redirect()->to('/');
            abort(403, 'Unauthorized action.');
        }
    }
}
