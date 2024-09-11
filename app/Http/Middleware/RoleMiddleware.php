<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{   
    public function handle(Request $request, Closure $next, $role)
    {
        // Ambil user yang sedang login
        $user = Auth::user();

        // Jika user tidak login atau role_id tidak sesuai
        if (!$user || $user->role->name !== $role) {
            // Redirect ke halaman yang diinginkan jika tidak sesuai
            return redirect('/home')->with('error', 'You do not have access to this page');
        }

        // Jika role cocok, lanjutkan request
        return $next($request);
    }
}
