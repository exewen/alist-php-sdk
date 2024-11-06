<?php
declare(strict_types=1);

namespace Exewen\Alist\Middleware;

use Exewen\Config\Contract\ConfigInterface;
use Exewen\Di\Container;
use Psr\Http\Message\RequestInterface;

class AuthMiddleware
{
//    private string $config;
    private $appConfig;
    private $config;
    private $channel;

    public function __construct(string $channel, array $config)
    {
        $this->appConfig = Container::getInstance()->get(ConfigInterface::class);
        $this->channel   = $channel;
        $this->config    = $config;
    }

    public function __invoke(callable $handler): callable
    {
        return function (RequestInterface $request, array $options) use ($handler) {
            $this->config    = $this->appConfig->get("http.channels.{$this->channel}"); // 刷新单例到最新配置
            $accessToken     = $this->config['extra']['access_token'] ?? '';
            $modifiedRequest = $request
                ->withHeader('Authorization', $accessToken);
            return $handler($modifiedRequest, $options);
        };
    }


}