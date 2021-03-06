<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class Language
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $lang = $request->route('lang');
        if (! in_array($lang, ['en', 'es', 'fr'])) {
            abort(400);
        }

        App::setLocale($lang);
        return $next($request);
    }
}
