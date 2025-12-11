<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class ScopeByRental
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        
        if ($user && $user->hasRole('SuperAdmin')) {
            return $next($request);
        }

        
        if ($user && ($user->hasRole('RentalOwner') || $user->hasRole('Employee'))) {
            if (empty($user->rental_id)) {
                
                Auth::logout();
                return redirect('/login')->withErrors(['error' => 'Brak przypisanej wypożyczalni. Skontaktuj się z administratorem.']);
            }

            
            return $next($request);
        }

        
        return $next($request);
    }
}