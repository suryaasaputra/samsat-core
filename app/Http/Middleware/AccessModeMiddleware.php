<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AccessModeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $mode
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $mode)
    {
        // Daftar IP atau jaringan internal untuk akses offline
        $allowedOfflineIps = [
            '127.0.0.0/8',    // Loopback
            '100.64.0.0/10',  // CGNAT Range
            '192.168.0.0/16', // Private Range
            '10.0.0.0/8',     // Private Range
        ];

        // Periksa apakah request berasal dari internal
        $isOffline = false;
        foreach ($allowedOfflineIps as $ip) {
            if ($this->ipInRange($request->ip(), $ip)) {
                $isOffline = true;
                break;
            }
        }

        // Logika pembatasan akses
        if ($mode === 'offline' && ! $isOffline) {
            abort(403, 'Resource ini hanya bisa diakses melalui jaringan internal Samsat .');
        }

        if ($mode === 'online' && $isOffline) {
            abort(403, 'Resource ini hanya bisa diakses secara online.');
        }

        return $next($request);
    }

    /**
     * Periksa apakah IP termasuk dalam rentang tertentu.
     */
    private function ipInRange($ip, $range)
    {
        if (strpos($range, '/') === false) {
            return $ip === $range;
        }

        [$subnet, $bits] = explode('/', $range);
        $ip              = ip2long($ip);
        $subnet          = ip2long($subnet);
        $mask            = -1 << (32 - $bits);

        return ($ip & $mask) === ($subnet & $mask);
    }
}
