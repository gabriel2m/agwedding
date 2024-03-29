<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfStatic
{
    public function handle(Request $request, Closure $next): Response
    {
        if (File::isFile(public_path($request->path()))) {
            return redirect(
                to: asset($request->path()),
                secure: $request->secure()
            );
        }

        return $next($request);
    }
}
