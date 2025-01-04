<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckSaranaAccess
{
    public function handle(Request $request, Closure $next)
    {
        $saranaId = $request->route('sarana'); 
        
        if (!auth()->user()->canAccessSarana($saranaId)) {
            abort(403, 'Anda tidak memiliki akses ke sarana ini.');
        }

        return $next($request);
    }
}