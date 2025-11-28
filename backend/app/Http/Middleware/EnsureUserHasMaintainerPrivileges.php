<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasMaintainerPrivileges
{
    public function handle(Request $request, Closure $next): Response
    {
        $isAuthenticated = auth()->check();
        $isMaintainer = $isAuthenticated && auth()->user()->is_maintainer;

        abort_if(!$isMaintainer, Response::HTTP_FORBIDDEN);

        return $next($request);
    }
}
