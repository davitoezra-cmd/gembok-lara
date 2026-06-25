<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleNotCustomer
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Pastikan user sudah login dan rolenya BUKAN customer
        if (Auth::check() && Auth::user()->role !== 'customer') {
            return $next($request);
        }

        // Jika dia customer atau belum login, lempar atau batalkan aksesnya
        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }
}