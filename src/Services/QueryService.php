<?php
declare(strict_types=1);

namespace Exewen\Alist\Services;

use Exewen\Config\Contract\ConfigInterface;
use Exewen\Http\Contract\HttpClientInterface;

class QueryService
{
    private $httpClient;
    private $driver;
    private $fsListUrl = '/api/fs/list';
    private $fsDirsListUrl = '/api/fs/dirs';
    private $fsGetUrl = '/api/fs/get';

    public function __construct(HttpClientInterface $httpClient, ConfigInterface $config)
    {
        $this->httpClient = $httpClient;
        $this->driver     = $config->get('alist.channel_api');
    }

    /**
     * 列出文件目录
     * @param array $params
     * @param array $header
     * @return string
     */
    public function getFs(array $params, array $header = []): string
    {
        return $this->httpClient->post($this->driver, $this->fsListUrl, $params, $header);
    }

    /**
     * 获取某个文件/目录信息
     * @param array $params
     * @param array $header
     * @return string
     */
    public function getFsGet(array $params, array $header = []): string
    {
        return $this->httpClient->post($this->driver, $this->fsGetUrl, $params, $header);
    }

    /**
     * 列出文件目录
     * @param array $params
     * @param array $header
     * @return string
     */
    public function getFsDirs(array $params, array $header = []): string
    {
        return $this->httpClient->post($this->driver, $this->fsDirsListUrl, $params, $header);
    }




}