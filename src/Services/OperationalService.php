<?php
declare(strict_types=1);

namespace Exewen\Alist\Services;

use Exewen\Config\Contract\ConfigInterface;
use Exewen\Http\Constants\HttpEnum;
use Exewen\Http\Contract\HttpClientInterface;

class OperationalService
{
    private $httpClient;
    private $driver;
    private $fileUploadUrl = '/api/fs/form';
    private $deleteUrl = '/api/fs/remove';
    private $mkdirUrl = '/api/fs/mkdir';
    private $renameUrl = '/api/fs/rename';
    private $batchRenameUrl = '/api/fs/batch_rename';
    private $moveUrl = '/api/fs/move';
    private $recursiveMoveUrl = '/api/fs/recursive_move';
    private $removeEmptyDirectoryUrl = '/api/fs/remove_empty_directory';

    public function __construct(HttpClientInterface $httpClient, ConfigInterface $config)
    {
        $this->httpClient = $httpClient;
        $this->driver     = $config->get('alist.channel_api');
    }


    /**
     * 上传文件/流式上传文件
     * @param string $filePath
     * @param string $alistFolder
     * @param string $type
     * @return string
     */
    public function fileUpload(string $filePath, string $alistFolder, string $type = HttpEnum::TYPE_MULTIPART)
    {
        $filename = basename($filePath);
        $fullPath = rtrim($alistFolder, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $filename;
        $header   = ['File-Path' => $fullPath];

        if ($type == HttpEnum::TYPE_MULTIPART) {
            $params = [
                [
                    'name'     => 'file',
                    'contents' => fopen($filePath, 'r')
                ]
            ];
            return $this->httpClient->put($this->driver, $this->fileUploadUrl, $params, $header, [], $type);
        } else {
            $options = [
                HttpEnum::TYPE_BODY => fopen($filePath, 'r')
            ];
            return $this->httpClient->put($this->driver, $this->fileUploadUrl, [], $header, $options, $type);
        }
    }

    /**
     * 删除文件或文件夹
     * @param array $params
     * @param array $header
     * @return string
     */
    public function delete(array $params, array $header = [])
    {
        return $this->httpClient->post($this->driver, $this->deleteUrl, $params, $header);
    }

    /**
     * 新建文件夹
     * @param array $params
     * @param array $header
     * @return string
     */
    public function mkdir(array $params, array $header = [])
    {
        return $this->httpClient->post($this->driver, $this->mkdirUrl, $params, $header);
    }

    /**
     * 重命名
     * @param array $params
     * @param array $header
     * @return string
     */
    public function rename(array $params, array $header = [])
    {
        return $this->httpClient->post($this->driver, $this->renameUrl, $params, $header);
    }

    /**
     * 批量重命名
     * @param array $params
     * @param array $header
     * @return string
     */
    public function batchRename(array $params, array $header = [])
    {
        return $this->httpClient->post($this->driver, $this->batchRenameUrl, $params, $header);
    }

    /**
     * 移动文件
     * @param array $params
     * @param array $header
     * @return string
     */
    public function move(array $params, array $header = [])
    {
        return $this->httpClient->post($this->driver, $this->moveUrl, $params, $header);
    }

    /**
     * 聚合移动
     * @param array $params
     * @param array $header
     * @return string
     */
    public function recursiveMove(array $params, array $header = [])
    {
        return $this->httpClient->post($this->driver, $this->recursiveMoveUrl, $params, $header);
    }

    /**
     * 删除空文件夹
     * @param array $params
     * @param array $header
     * @return string
     */
    public function removeEmptyDirectory(array $params, array $header = [])
    {
        return $this->httpClient->post($this->driver, $this->removeEmptyDirectoryUrl, $params, $header);
    }

}