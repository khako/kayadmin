<?php

namespace Kaya\Admin\Middlewares;

use Closure;
use Cookie;
use Kaya\Admin\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        $redirect = app()->config['kayadmin']['redirect'];

        if (Auth::guest()) {
            return redirect($redirect);
        }

        if (!User::make(Auth::user())->hasRole('admin')) {
            return redirect($redirect);
        }

        return $next($request)->cookie('token', \JWTAuth::fromUser(User::make(auth()->user())));
    }
}
