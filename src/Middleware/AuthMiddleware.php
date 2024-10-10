<?php
declare(strict_types=1);

namespace Exewen\Alist\Middleware;

use Psr\Http\Message\RequestInterface;

class AuthMiddleware
{
//    private string $config;
    private $config;
    private $channel;

    public function __construct(string $channel, array $config)
    {
        $this->channel = $channel;
        $this->config  = $config;
    }

    public function __invoke(callable $handler): callable
    {
        return function (RequestInterface $request, array $options) use ($handler) {
            $accessToken     = $this->config['extra']['access_token'] ?? '';
            $modifiedRequest = $request
                ->withHeader('Authorization', $accessToken);
            return $handler($modifiedRequest, $options);
        };
    }


}