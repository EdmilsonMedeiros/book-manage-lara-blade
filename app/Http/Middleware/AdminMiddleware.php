<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::user() || !Auth::user()->hasPermissionTo('admin')) {
            Auth::logout();
            return redirect()->back()->with('error', 'Acesso não autorizado. Você precisa ter permissão de administrador.');
        }

        return $next($request);
    }
}
