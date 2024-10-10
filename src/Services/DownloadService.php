<?php
declare(strict_types=1);

namespace Exewen\Alist\Services;

use Exewen\Config\Contract\ConfigInterface;
use Exewen\Http\Contract\HttpClientInterface;

class DownloadService
{
    private $httpClient;
    private $driver;
    private $downloadUrl = '/api/fs/add_offline_download';

    public function __construct(HttpClientInterface $httpClient, ConfigInterface $config)
    {
        $this->httpClient = $httpClient;
        $this->driver     = $config->get('alist.channel_api');
    }

    /**
     * 文件下载
     * @param array $params
     * @param array $header
     * @return string
     */
    public function downloadFile(array $params, array $header = []): string
    {
        return $this->httpClient->post($this->driver, $this->downloadUrl, $params, $header);
    }


}