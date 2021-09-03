<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfficerType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $officer_type)
    {
        $role = Auth::user()->officer_type;

        if ($role == $officer_type) {
            return $next($request);
        } else if (
            $officer_type == "Admin&BC"
            && ($role == "Administrator"
                || $role == "Barangay Captain")
        ) {
            return $next($request);
        } else {
            abort(500);
            // abort(403, "Your do not have access to this page or resource for some reasons.");
        }
    }
}