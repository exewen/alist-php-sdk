<?php
declare(strict_types=1);

namespace Exewen\Alist\Services;

use Exewen\Config\Contract\ConfigInterface;
use Exewen\Http\Contract\HttpClientInterface;

class AuthService
{
    private $httpClient;
    private $driver;
    private $tokenUrl = '/api/auth/login';

    public function __construct(HttpClientInterface $httpClient, ConfigInterface $config)
    {
        $this->httpClient = $httpClient;
        $this->driver     = $config->get('alist.channel_auth');
    }

    /**
     * 授权
     * @param string $username
     * @param string $password
     * @param array $header
     * @return string
     */
    public function getToken(string $username, string $password, array $header = []): string
    {
        $params = [
            'username' => $username,
            'password' => $password
        ];
        return $this->httpClient->post($this->driver, $this->tokenUrl, $params, $header);
    }


}