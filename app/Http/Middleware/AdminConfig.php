<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminConfig
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $admin = Admin::count();
        $role = Auth::user()->officer_type;
        if ($admin == 0 && $role == "Administrator") {
            abort(403, "You do not have access to this page or resource. Please set up your account first.");
        } else {
            return $next($request);
        }
    }
}