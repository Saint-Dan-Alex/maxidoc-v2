<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\DB;

class MarkAuthenticationSuccess
{
    public function handle(Login $event): void
    {
        try {
            $user = $event->user;
            $ip = request()->ip();
            $ua = request()->userAgent();

            // Try update the latest pending row for this user + fingerprint
            $updated = DB::table('authentication_log')
                ->where('authenticatable_type', get_class($user))
                ->where('authenticatable_id', $user->getAuthIdentifier())
                ->when($ip, fn($q) => $q->where('ip_address', $ip))
                ->when($ua, fn($q) => $q->where('user_agent', $ua))
                ->where(function ($q) {
                    $q->whereNull('login_at')->orWhere('login_successful', false);
                })
                ->orderByDesc('id')
                ->limit(1)
                ->update([
                    'login_at' => now(),
                    'login_successful' => true,
                ]);

            if (!$updated) {
                // Fallback: insert a fresh successful row
                DB::table('authentication_log')->insert([
                    'authenticatable_type' => get_class($user),
                    'authenticatable_id' => $user->getAuthIdentifier(),
                    'ip_address' => $ip,
                    'user_agent' => $ua,
                    'login_at' => now(),
                    'login_successful' => true,
                    'logout_at' => null,
                    'cleared_by_user' => false,
                    'location' => null,
                ]);
            }
        } catch (\Throwable $e) {
            // Swallow to not break login flow
        }
    }
}
