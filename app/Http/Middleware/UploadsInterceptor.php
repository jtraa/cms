<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class UploadsInterceptor
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
        // Check if the requested disk is 'uploads'
//        if (Storage::getDefaultDriver() == 'uploads') {
//            // Forward the request to the 'store' method of your ImageController
//            return app('App\Http\Controllers\ImageController')->store($request);
//        }
//
//        return $next($request);
    }
}
