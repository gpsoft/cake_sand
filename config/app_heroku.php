<?php
use Cake\Database\Driver\Postgres;
return [
    'debug' => filter_var(env('DEBUG', false), FILTER_VALIDATE_BOOLEAN),
    'Security' => [
        'salt' => env('SECURITY_SALT', ''),
    ],
    'Datasources' => [
        'default' => [
            'driver' => Postgres::class,
            'encoding' => 'utf8',
            'database' => 'cake_sand',
            'url' => env('DATABASE_URL', null),
        ],
    ],
];
