<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles )
    {
        if (!Auth::check()) {
            return redirect('/');
        }

        $user = Auth::user();

        if (!in_array($user->id_role, $roles)) {
            if ($user->id_role == 1) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->id_role == 2) {
                return redirect()->route('user.dashboard');
            } else {
                return redirect('/')->with('error', 'You do not have permission to access this page.');
            }
        }

        return $next($request);
    }   
}