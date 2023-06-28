<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Route;

class AdminAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $controllerAction = class_basename(Route::currentRouteName());
        if (isset($controllerAction)) {
            $permitedMenuArr = App::make('premitedMenuArr');
            if (! in_array($controllerAction, $permitedMenuArr)) {
                return abort(403);
            }
            if ($request->format() == 'html') {
                return response(view('admin.layouts.admin_app'));
            } elseif ($request->format() == 'json') {
                return $next($request);
            } else {
                abort(404);
            }
        }
    }
}
