<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Cog;

class License
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
        if((new Cog)->verify()){
            
            return redirect()->route('welcome')->with('msg', 'Licensa expirada, por favor, entre em contacto para adquirir uma nova licensa');
        }
        return $next($request);
    }
}
