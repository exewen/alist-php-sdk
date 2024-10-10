<?php

declare(strict_types=1);

use Exewen\Alist\Middleware\AuthMiddleware;
use Exewen\Http\Middleware\LogMiddleware;
use Exewen\Alist\Constants\AlistEnum;

return [
    'channels' => [
        AlistEnum::CHANNEL_AUTH => [
            'verify'          => false,
            'ssl'             => true,
            'host'            => 'alist.test.com',
            'port'            => null,
            'prefix'          => null,
            'connect_timeout' => 3,
            'timeout'         => 20,
            'handler'         => [
                LogMiddleware::class,
            ],
            'extra'           => [],
            'proxy'           => [
                'switch' => false,
                'http'   => '127.0.0.1:8888',
                'https'  => '127.0.0.1:8888'
            ]
        ],
        AlistEnum::CHANNEL_API  => [
            'verify'          => false,
            'ssl'             => true,
            'host'            => 'alist.test.com',
            'port'            => null,
            'prefix'          => null,
            'connect_timeout' => 3,
            'timeout'         => 20,
            'handler'         => [
                LogMiddleware::class,
                AuthMiddleware::class,
            ],
            'extra'           => [],
            'proxy'           => [
                'switch' => false,
                'http'   => '127.0.0.1:8888',
                'https'  => '127.0.0.1:8888'
            ]
        ],
    ]
];