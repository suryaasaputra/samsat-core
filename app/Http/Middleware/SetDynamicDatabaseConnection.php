<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class SetDynamicDatabaseConnection
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
        if (Auth::check()) {
            $kdWilayah = Auth::user()->kd_wilayah;

            // Map `kd_wilayah` to the database connection name
            $connectionName = match ($kdWilayah) {
                '001' => '001',
                '002' => '002',
                '003' => '003',
                '004' => '004',
                '005' => '005',
                '006' => '006',
                '007' => '007',
                '008' => '008',
                '009' => '009',
                '010' => '010',
                '011' => '011',
                default => 'pgsql', // Default connection
            };

            // Set the connection dynamically
            Config::set('database.default', $connectionName);
            DB::purge(); // Clear current connection to apply changes
        }

        return $next($request);
    }
}