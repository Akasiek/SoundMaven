<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasAdminPrivileges
{
    public function handle(Request $request, Closure $next): Response
    {
        $isAuthenticated = auth()->hasUser();
        $isAdmin = $isAuthenticated && auth()->user()->is_admin;

        abort_if(!$isAdmin, Response::HTTP_FORBIDDEN);

        return $next($request);
    }
}
