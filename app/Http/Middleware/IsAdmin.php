<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Auth;

class IsAdmin
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

        if (
            Auth::user()
            && Auth::user()->role == User::ROLE_ADMIN
        ) {
            return $next($request);
        }

        return redirect('dashboard');
    }
}
