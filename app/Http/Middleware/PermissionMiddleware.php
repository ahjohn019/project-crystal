<?php

namespace App\Http\Middleware;

use Closure;
use App\Library\RoleTag;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permissions): Response
    {
        $domainRole = $request->route()->action['namespace'];

        $roleTag = $permissions == "web" ? RoleTag::getAllUser() : RoleTag::getAllAdmin();

        $authRole = auth()->user()->roles[0]->name;

        $checkRole = in_array($authRole, $roleTag);

        if ($domainRole == $authRole && $checkRole) {
            return $next($request);
        }

        abort(403, 'Unauthorized');
    }
}
