<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckActiveDelegation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            $now = now();
            $delegation = \App\Models\Delegation::where('delegate_id', auth()->id())
                ->where('is_active', true)
                ->where('start_date', '<=', $now)
                ->where('end_date', '>=', $now)
                ->first();

            if ($delegation) {
                // Injection contextuelle du DG déléguant
                session(['acting_as_dg_id' => $delegation->delegator_id]);
                session(['delegation_mode' => true]);
            } else {
                session()->forget(['acting_as_dg_id', 'delegation_mode']);
            }
        }

        return $next($request);
    }
}
