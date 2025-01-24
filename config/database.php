<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
     */

    'default'     => env('DB_CONNECTION', 'pgsql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
     */

    'connections' => [

        'sqlite' => [
            'driver'                  => 'sqlite',
            'url'                     => env('DATABASE_URL'),
            'database'                => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix'                  => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],

        'mysql'  => [
            'driver'         => 'mysql',
            'url'            => env('DATABASE_URL'),
            'host'           => env('DB_HOST', '127.0.0.1'),
            'port'           => env('DB_PORT', '3306'),
            'database'       => env('DB_DATABASE', 'forge'),
            'username'       => env('DB_USERNAME', 'forge'),
            'password'       => env('DB_PASSWORD', ''),
            'unix_socket'    => env('DB_SOCKET', ''),
            'charset'        => 'utf8mb4',
            'collation'      => 'utf8mb4_unicode_ci',
            'prefix'         => '',
            'prefix_indexes' => true,
            'strict'         => true,
            'engine'         => null,
            'options'        => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'pgsql'  => [
            'driver'         => 'pgsql',
            'url'            => env('DATABASE_URL'),
            'host'           => env('DB_HOST', '127.0.0.1'),
            'port'           => env('DB_PORT', '5432'),
            'database'       => env('DB_DATABASE', 'forge'),
            'username'       => env('DB_USERNAME', 'forge'),
            'password'       => env('DB_PASSWORD', ''),
            'charset'        => 'utf8',
            'prefix'         => '',
            'prefix_indexes' => true,
            'schema'         => 'public',
            'sslmode'        => 'prefer',
        ],

        'sqlsrv' => [
            'driver'         => 'sqlsrv',
            'url'            => env('DATABASE_URL'),
            'host'           => env('DB_HOST', 'localhost'),
            'port'           => env('DB_PORT', '1433'),
            'database'       => env('DB_DATABASE', 'forge'),
            'username'       => env('DB_USERNAME', 'forge'),
            'password'       => env('DB_PASSWORD', ''),
            'charset'        => 'utf8',
            'prefix'         => '',
            'prefix_indexes' => true,
        ],

        'induk'  => [
            'driver'   => env('DB_INDUK_CONNECTION', 'pgsql'),
            'host'     => env('DB_INDUK_HOST', '127.0.0.1'),
            'port'     => env('DB_INDUK_PORT', '5432'),
            'database' => env('DB_INDUK_DATABASE', 'forge'),
            'username' => env('DB_INDUK_USERNAME', 'forge'),
            'password' => env('DB_INDUK_PASSWORD', ''),
            'charset'  => 'utf8',
            'prefix'   => '',
            'schema'   => 'public',
        ],
        '000'    => [
            'driver'   => env('DB_INDUK_CONNECTION', 'pgsql'),
            'host'     => env('DB_INDUK_HOST', '127.0.0.1'),
            'port'     => env('DB_INDUK_PORT', '5432'),
            'database' => env('DB_INDUK_DATABASE', 'forge'),
            'username' => env('DB_INDUK_USERNAME', 'forge'),
            'password' => env('DB_INDUK_PASSWORD', ''),
            'charset'  => 'utf8',
            'prefix'   => '',
            'schema'   => 'public',
        ],

        '001'    => [
            'driver'   => env('DB_KOTA_CONNECTION', 'pgsql'),
            'host'     => env('DB_KOTA_HOST', '127.0.0.1'),
            'port'     => env('DB_KOTA_PORT', '5432'),
            'database' => env('DB_KOTA_DATABASE', 'forge'),
            'username' => env('DB_KOTA_USERNAME', 'forge'),
            'password' => env('DB_KOTA_PASSWORD', ''),
            'charset'  => 'utf8',
            'prefix'   => '',
            'schema'   => 'public',
        ],

        '002'    => [
            'driver'   => env('DB_BATANGHARI_CONNECTION', 'pgsql'),
            'host'     => env('DB_BATANGHARI_HOST', '127.0.0.1'),
            'port'     => env('DB_BATANGHARI_PORT', '5432'),
            'database' => env('DB_BATANGHARI_DATABASE', 'forge'),
            'username' => env('DB_BATANGHARI_USERNAME', 'forge'),
            'password' => env('DB_BATANGHARI_PASSWORD', ''),
            'charset'  => 'utf8',
            'prefix'   => '',
            'schema'   => 'public',
        ],
        '003'    => [
            'driver'   => env('DB_TANJABBARAT_CONNECTION', 'pgsql'),
            'host'     => env('DB_TANJABBARAT_HOST', '127.0.0.1'),
            'port'     => env('DB_TANJABBARAT_PORT', '5432'),
            'database' => env('DB_TANJABBARAT_DATABASE', 'forge'),
            'username' => env('DB_TANJABBARAT_USERNAME', 'forge'),
            'password' => env('DB_TANJABBARAT_PASSWORD', ''),
            'charset'  => 'utf8',
            'prefix'   => '',
            'schema'   => 'public',
        ],
        '004'    => [
            'driver'   => env('DB_MERANGIN_CONNECTION', 'pgsql'),
            'host'     => env('DB_MERANGIN_HOST', '127.0.0.1'),
            'port'     => env('DB_MERANGIN_PORT', '5432'),
            'database' => env('DB_MERANGIN_DATABASE', 'forge'),
            'username' => env('DB_MERANGIN_USERNAME', 'forge'),
            'password' => env('DB_MERANGIN_PASSWORD', ''),
            'charset'  => 'utf8',
            'prefix'   => '',
            'schema'   => 'public',
        ],

        '005'    => [
            'driver'   => env('DB_BUNGO_CONNECTION', 'pgsql'),
            'host'     => env('DB_BUNGO_HOST', '127.0.0.1'),
            'port'     => env('DB_BUNGO_PORT', '5432'),
            'database' => env('DB_BUNGO_DATABASE', 'forge'),
            'username' => env('DB_BUNGO_USERNAME', 'forge'),
            'password' => env('DB_BUNGO_PASSWORD', ''),
            'charset'  => 'utf8',
            'prefix'   => '',
            'schema'   => 'public',
        ],

        '006'    => [
            'driver'   => env('DB_KERINCI_CONNECTION', 'pgsql'),
            'host'     => env('DB_KERINCI_HOST', '127.0.0.1'),
            'port'     => env('DB_KERINCI_PORT', '5432'),
            'database' => env('DB_KERINCI_DATABASE', 'forge'),
            'username' => env('DB_KERINCI_USERNAME', 'forge'),
            'password' => env('DB_KERINCI_PASSWORD', ''),
            'charset'  => 'utf8',
            'prefix'   => '',
            'schema'   => 'public',
        ],

        '007'    => [
            'driver'   => env('DB_TANJABTIMUR_CONNECTION', 'pgsql'),
            'host'     => env('DB_TANJABTIMUR_HOST', '127.0.0.1'),
            'port'     => env('DB_TANJABTIMUR_PORT', '5432'),
            'database' => env('DB_TANJABTIMUR_DATABASE', 'forge'),
            'username' => env('DB_TANJABTIMUR_USERNAME', 'forge'),
            'password' => env('DB_TANJABTIMUR_PASSWORD', ''),
            'charset'  => 'utf8',
            'prefix'   => '',
            'schema'   => 'public',
        ],

        '008'    => [
            'driver'   => env('DB_MUAROJAMBI_CONNECTION', 'pgsql'),
            'host'     => env('DB_MUAROJAMBI_HOST', '127.0.0.1'),
            'port'     => env('DB_MUAROJAMBI_PORT', '5432'),
            'database' => env('DB_MUAROJAMBI_DATABASE', 'forge'),
            'username' => env('DB_MUAROJAMBI_USERNAME', 'forge'),
            'password' => env('DB_MUAROJAMBI_PASSWORD', ''),
            'charset'  => 'utf8',
            'prefix'   => '',
            'schema'   => 'public',
        ],
        '009'    => [
            'driver'   => env('DB_SAROLANGUN_CONNECTION', 'pgsql'),
            'host'     => env('DB_SAROLANGUN_HOST', '127.0.0.1'),
            'port'     => env('DB_SAROLANGUN_PORT', '5432'),
            'database' => env('DB_SAROLANGUN_DATABASE', 'forge'),
            'username' => env('DB_SAROLANGUN_USERNAME', 'forge'),
            'password' => env('DB_SAROLANGUN_PASSWORD', ''),
            'charset'  => 'utf8',
            'prefix'   => '',
            'schema'   => 'public',
        ],
        '010'    => [
            'driver'   => env('DB_TEBO_CONNECTION', 'pgsql'),
            'host'     => env('DB_TEBO_HOST', '127.0.0.1'),
            'port'     => env('DB_TEBO_PORT', '5432'),
            'database' => env('DB_TEBO_DATABASE', 'forge'),
            'username' => env('DB_TEBO_USERNAME', 'forge'),
            'password' => env('DB_TEBO_PASSWORD', ''),
            'charset'  => 'utf8',
            'prefix'   => '',
            'schema'   => 'public',
        ],
        '011'    => [
            'driver'   => env('DB_SUNGAIPENUH_CONNECTION', 'pgsql'),
            'host'     => env('DB_SUNGAIPENUH_HOST', '127.0.0.1'),
            'port'     => env('DB_SUNGAIPENUH_PORT', '5432'),
            'database' => env('DB_SUNGAIPENUH_DATABASE', 'forge'),
            'username' => env('DB_SUNGAIPENUH_USERNAME', 'forge'),
            'password' => env('DB_SUNGAIPENUH_PASSWORD', ''),
            'charset'  => 'utf8',
            'prefix'   => '',
            'schema'   => 'public',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
     */

    'migrations'  => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer body of commands than a typical key-value system
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
     */

    'redis'       => [

        'client'  => env('REDIS_CLIENT', 'phpredis'),

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix'  => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_') . '_database_'),
        ],

        'default' => [
            'url'      => env('REDIS_URL'),
            'host'     => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port'     => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
        ],

        'cache'   => [
            'url'      => env('REDIS_URL'),
            'host'     => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port'     => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB', '1'),
        ],

    ],

];
