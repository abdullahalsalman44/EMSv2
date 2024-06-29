<?php

namespace App\Http\Middleware;

use App\Models\EmailVerification;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DeleteEmailMiddleWare
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = User::query()->where('email', '=', $request['email'])->first();
        if ($user != null && $user->email_verified_at == null) {
            $user->delete();
            return $next($request);
        }
        return $next($request);
    }
}
