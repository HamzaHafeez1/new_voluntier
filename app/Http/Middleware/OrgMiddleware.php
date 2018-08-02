<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class OrgMiddleware
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
        if(Auth::check() && $request->route()->getName() == "view-organization-profile") {
			return $next($request);
		}
        elseif(Auth::check() && $request->route()->getName() == "view-opportunity-profile") {
			return $next($request);
		}
        elseif(Auth::check() && Auth::user()->user_role == 'organization'){
			return $next($request);
        }
        else{
            return Redirect()->to('/');
            abort(403, 'Unauthorized action.');
        }
    }
}
