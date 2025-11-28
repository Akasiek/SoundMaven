<?php

namespace App\Http\Middleware;

use App\Enums\UserRolesEnum;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasMaintainerPrivileges
{
    public function handle(Request $request, Closure $next): Response
    {
        $isAuthenticated = auth()->check();
        $isMaintainerOrAdmin = $isAuthenticated && in_array(auth()->user()->role, [UserRolesEnum::MAINTAINER, UserRolesEnum::ADMIN]);

        abort_if(!$isMaintainerOrAdmin, Response::HTTP_FORBIDDEN);

        return $next($request);
    }
}
