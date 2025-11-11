<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MarkAuthenticationSuccess
{
    public function handle(Login $event): void
    {
        try {
            $user = $event->user;
            $ip = request()->ip(); // IP vue par l'app (peut être celle du proxy)
            $ua = request()->userAgent();
            $clientIp = $this->clientIp() ?: $ip; // IP potentielle réelle du client
            $locArray = $this->lookupLocation($clientIp);

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
                ->update(array_filter([
                    'login_at' => now(),
                    'login_successful' => true,
                    // Renseigne la localisation uniquement si obtenue
                    'location' => $locArray ? json_encode($locArray) : null,
                ], fn($v) => !is_null($v)));

            // Si aucune ligne mise à jour (IP proxy stockée différente), tenter avec l'IP client détectée
            if (!$updated && $clientIp && $clientIp !== $ip) {
                $updated = DB::table('authentication_log')
                    ->where('authenticatable_type', get_class($user))
                    ->where('authenticatable_id', $user->getAuthIdentifier())
                    ->where('ip_address', $clientIp)
                    ->when($ua, fn($q) => $q->where('user_agent', $ua))
                    ->where(function ($q) {
                        $q->whereNull('login_at')->orWhere('login_successful', false);
                    })
                    ->orderByDesc('id')
                    ->limit(1)
                    ->update(array_filter([
                        'login_at' => now(),
                        'login_successful' => true,
                        'location' => $locArray ? json_encode($locArray) : null,
                    ], fn($v) => !is_null($v)));
            }

            // Si toujours rien, il se peut que la ligne soit déjà "succès" mais sans location: compléter
            if (!$updated) {
                $updated = DB::table('authentication_log')
                    ->where('authenticatable_type', get_class($user))
                    ->where('authenticatable_id', $user->getAuthIdentifier())
                    ->when($ua, fn($q) => $q->where('user_agent', $ua))
                    ->where('login_successful', true)
                    ->whereNull('location')
                    ->orderByDesc('id')
                    ->limit(1)
                    ->update(array_filter([
                        'location' => $locArray ? json_encode($locArray) : null,
                    ], fn($v) => !is_null($v)));
            }

            if (!$updated) {
                // Fallback: insert a fresh successful row
                DB::table('authentication_log')->insert([
                    'authenticatable_type' => get_class($user),
                    'authenticatable_id' => $user->getAuthIdentifier(),
                    'ip_address' => $clientIp,
                    'user_agent' => $ua,
                    'login_at' => now(),
                    'login_successful' => true,
                    'logout_at' => null,
                    'cleared_by_user' => false,
                    'location' => $locArray ? json_encode($locArray) : null,
                ]);
            }
        } catch (\Throwable $e) {
            // Swallow to not break login flow
        }
    }

    private function clientIp(): ?string
    {
        // 1) Cloudflare
        $cf = request()->headers->get('CF-Connecting-IP');
        if ($this->isPublicIp($cf)) return $cf;

        // 2) Nginx/Proxy direct
        $xri = request()->headers->get('X-Real-IP');
        if ($this->isPublicIp($xri)) return $xri;

        // 3) Chaîne d'IPs
        $xff = request()->headers->get('X-Forwarded-For');
        if ($xff) {
            foreach (explode(',', $xff) as $part) {
                $candidate = trim($part);
                if ($this->isPublicIp($candidate)) {
                    return $candidate;
                }
            }
        }

        // 4) Fallback
        return request()->ip();
    }

    private function isPublicIp(?string $ip): bool
    {
        if (!$ip) return false;
        if (!filter_var($ip, FILTER_VALIDATE_IP)) return false;
        // exclut private/reserved ranges
        return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false;
    }

    private function lookupLocation(?string $ip): ?array
    {
        try {
            if (!$ip || $ip === '127.0.0.1' || $ip === '::1') {
                return null;
            }
            // 1) ipapi.co
            $res = Http::withHeaders(['User-Agent' => 'Maxidoc/1.0 Laravel-HTTP'])
                ->retry(2, 300)
                ->timeout(5)
                ->get("https://ipapi.co/{$ip}/json/");
            if ($res->ok()) {
                $data = $res->json();
                if (is_array($data)) {
                    Log::info('Geo OK ipapi', ['ip' => $ip, 'city' => $data['city'] ?? null]);
                    return [
                        'ip' => $ip,
                        'latitude' => $data['latitude'] ?? null,
                        'longitude' => $data['longitude'] ?? null,
                        'city' => $data['city'] ?? null,
                        'regionCode' => $data['region_code'] ?? null,
                        'countryCode' => $data['country_code'] ?? null,
                        'org' => $data['org'] ?? null,
                    ];
                }
            }

            // 2) fallback: ip-api.com
            $res2 = Http::withHeaders(['User-Agent' => 'Maxidoc/1.0 Laravel-HTTP'])
                ->retry(2, 300)
                ->timeout(5)
                ->get("http://ip-api.com/json/{$ip}?fields=status,countryCode,regionName,city,lat,lon,org");
            if ($res2->ok()) {
                $data2 = $res2->json();
                if (is_array($data2) && ($data2['status'] ?? '') === 'success') {
                    Log::info('Geo OK ip-api', ['ip' => $ip, 'city' => $data2['city'] ?? null]);
                    return [
                        'ip' => $ip,
                        'latitude' => $data2['lat'] ?? null,
                        'longitude' => $data2['lon'] ?? null,
                        'city' => $data2['city'] ?? null,
                        'regionCode' => $data2['regionName'] ?? null,
                        'countryCode' => $data2['countryCode'] ?? null,
                        'org' => $data2['org'] ?? null,
                    ];
                }
            }
            
            Log::warning('Geo failed for IP', [
                'ip' => $ip,
                'ipapi_status' => $res->status() ?? null,
                'ipapi_body' => method_exists($res, 'body') ? substr($res->body(), 0, 200) : null,
                'ipapi_error' => method_exists($res, 'reason') ? $res->reason() : null,
                'ipapi_ok' => method_exists($res, 'ok') ? $res->ok() : null,
                'ipapi_url' => "https://ipapi.co/{$ip}/json/",
                'ipapi2_status' => isset($res2) ? $res2->status() : null,
                'ipapi2_body' => isset($res2) && method_exists($res2, 'body') ? substr($res2->body(), 0, 200) : null,
            ]);
            return null;
        } catch (\Throwable $e) {
            Log::warning('Geo exception', ['ip' => $ip ?? null, 'err' => $e->getMessage()]);
            return null;
        }
    }
}
