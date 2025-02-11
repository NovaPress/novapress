<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminGuestMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            if (str_contains(url()->previous(), 'admin')) {
                if (url()->previous() != url()->current()) {
                    return redirect()->to(url()->previous());
                }
            }

            return redirect()->to(route('admin.index'));
        } else {
            return $next($request);
        }
    }
}
