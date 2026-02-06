<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LoadUserSetting
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && $request->user()->enabled_notification) {
            config()->push('adminlte.menu', [
                'type'            => 'navbar-notification',
                'id'              => 'my-notification',
                'icon'            => 'fas fa-bell',
                'url'             => 'notifications/show',
                'topnav_right'    => true,
                'dropdown_mode'   => true,
                'dropdown_flabel' => 'All notifications',
                'update_cfg'      => [
                    'url'    => 'notifications/get',
                    'period' => 30,
                ],
            ]);
        }

        return $next($request);
    }
}
