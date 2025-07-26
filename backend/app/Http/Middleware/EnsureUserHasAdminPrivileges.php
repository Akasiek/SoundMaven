<?php

namespace App\Http\Middleware;

use App\Enums\UserRoles;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasAdminPrivileges
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        return !auth()->user() || auth()->user()->role !== UserRoles::ADMIN
            ? redirect()->route('home')->with('error', 'You do not have permission to access this page.')
            : $next($request);
    }
}
