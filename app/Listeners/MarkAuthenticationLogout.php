<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\DB;

class MarkAuthenticationLogout
{
    public function handle(Logout $event): void
    {
        try {
            $user = $event->user;
            if (!$user) { return; }
            $ip = request()->ip();
            $ua = request()->userAgent();

            DB::table('authentication_log')
                ->where('authenticatable_type', get_class($user))
                ->where('authenticatable_id', $user->getAuthIdentifier())
                ->when($ip, fn($q) => $q->where('ip_address', $ip))
                ->when($ua, fn($q) => $q->where('user_agent', $ua))
                ->where('login_successful', true)
                ->whereNull('logout_at')
                ->orderByDesc('id')
                ->limit(1)
                ->update(['logout_at' => now()]);
        } catch (\Throwable $e) {
            // no-op
        }
    }
}
