<?php

namespace App\Http\Middleware;

use App\Enums\UserRolesEnum;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasMaintainerPrivileges
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        return !auth()->user() || !in_array(auth()->user()->role, [UserRolesEnum::MAINTAINER, UserRolesEnum::ADMIN])
            ? redirect()->route('home')->with('error', 'You do not have permission to access this page.')
            : $next($request);
    }
}
