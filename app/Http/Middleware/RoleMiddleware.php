<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string ...$roles
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
    
        $user = Auth::user();
    
        // Check user role and allowed roles
        //dd($user->role, $roles);
    
        if (!$user->hasAnyRole($roles)) {
            abort(403, 'Unauthorized');
        }
    
        return $next($request);
    }
    
}
