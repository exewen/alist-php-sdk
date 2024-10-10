<?php

declare(strict_types=1);

namespace Exewen\Alist;

use Exewen\Alist\Constants\AlistEnum;
use Exewen\Alist\Contract\AlistInterface;
use Exewen\Alist\Middleware\AuthMiddleware;
use Exewen\Http\Middleware\LogMiddleware;

class ConfigRegister
{
    public function __invoke(): array
    {
        return [
            'dependencies' => [
                AlistInterface::class => Alist::class,
            ],

            'alist' => [
                'channel_auth' => AlistEnum::CHANNEL_AUTH,
                'channel_api'  => AlistEnum::CHANNEL_API,
            ],

            'http' => [
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
            ]


        ];
    }
}
