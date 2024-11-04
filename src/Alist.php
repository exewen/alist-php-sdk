<?php

declare(strict_types=1);

namespace Exewen\Alist;

use Exewen\Alist\Constants\AlistEnum;
use Exewen\Alist\Contract\AlistInterface;
use Exewen\Alist\Exception\AlistException;
use Exewen\Alist\Services\AuthService;
use Exewen\Alist\Services\DownloadService;
use Exewen\Alist\Services\QueryService;
use Exewen\Alist\Services\OperationalService;
use Exewen\Config\Contract\ConfigInterface;
use Exewen\Http\Constants\HttpEnum;

class Alist implements AlistInterface
{
    private $config;
    private $authService;
    private $queryService;
    private $operationalService;

    private $downloadService;

    public function __construct(
        ConfigInterface    $config,
        AuthService        $authService,
        QueryService       $queryService,
        OperationalService $operationalService,
        DownloadService    $downloadService
    )
    {
        $this->config             = $config;
        $this->authService        = $authService;
        $this->queryService       = $queryService;
        $this->operationalService = $operationalService;
        $this->downloadService    = $downloadService;
    }

    public function setAccessToken(string $accessToken, string $channel = AlistEnum::CHANNEL_API)
    {
        $this->config->set('http.channels.' . $channel . '.extra.access_token', $accessToken);
    }

    /**
     * 授权
     * @param string $username
     * @param string $password
     * @return mixed
     */
    public function getToken(string $username, string $password)
    {
        $response = $this->authService->getToken($username, $password);
        $result   = json_decode($response, true);
        if (!isset($result['data']['token'])) {
            throw new AlistException("获取token异常($response)");
        }
        return $result['data']['token'];
    }

    /**
     * 列出文件目录
     * @param string $path
     * @param int $page
     * @param int $limit
     * @param bool $refresh
     * @param string $password
     * @return mixed
     */
    public function getList(string $path, int $page = 1, int $limit = 20, bool $refresh = false, string $password = '')
    {
        $params   = [
            'path'     => $path,
            'password' => $password,
            'page'     => $page,
            'per_page' => $limit,
            'refresh'  => $refresh,
        ];
        $response = $this->queryService->getFs($params);
        $result   = json_decode($response, true);
        if (!isset($result['code']) || $result['code'] !== 200) {
            throw new AlistException(__FUNCTION__ . "异常：($response)");
        }
        return $result['data'];
    }

    /**
     * 获取某个文件/目录信息
     * @param string $path
     * @param int $page
     * @param int $limit
     * @param bool $refresh
     * @param string $password
     * @return mixed
     */
    public function getListDetail(string $path, int $page = 1, int $limit = 20, bool $refresh = false, string $password = '')
    {
        $params   = [
            'path'     => $path,
            'password' => $password,
            'page'     => $page,
            'per_page' => $limit,
            'refresh'  => $refresh,
        ];
        $response = $this->queryService->getFsGet($params);
        $result   = json_decode($response, true);
        if (!isset($result['code']) || $result['code'] !== 200) {
            throw new AlistException(__FUNCTION__ . "异常：($response)");
        }
        return $result['data'];
    }

    /**
     * 列出目录
     * @param string $path
     * @param string $password
     * @return mixed
     */
    public function getListDirs(string $path, string $password = '')
    {
        $params   = [
            'path'       => $path,
            'password'   => $password,
            'force_root' => false,
        ];
        $response = $this->queryService->getFsDirs($params);
        $result   = json_decode($response, true);
        if (!isset($result['code']) || $result['code'] !== 200) {
            throw new AlistException(__FUNCTION__ . "异常：($response)");
        }
        return $result['data'];
    }


    /**
     * 上传文件/流式上传文件
     * @param string $filePath
     * @param string $alistFolder
     * @param string $type
     * @param int $timeout
     * @return true
     */
    public function upload(string $filePath, string $alistFolder, string $type = HttpEnum::TYPE_MULTIPART, int $timeout = 1200)
    {
        if (!is_file($filePath)) {
            throw new AlistException("文件不存在：$filePath");
        }
        $response = $this->operationalService->fileUpload($filePath, $alistFolder, $type, $timeout);
        $result   = json_decode($response, true);
        if (!isset($result['code']) || $result['code'] !== 200) {
            throw new AlistException(__FUNCTION__ . "异常：($response)");
        }
        return true;
    }

    /**
     * 删除文件或文件夹
     * @param string $alistFolder
     * @param array $removeFiles
     * @param int $timeout
     * @return true
     */
    public function delete(string $alistFolder, array $removeFiles, int $timeout = 30)
    {
        $params   = [
            'dir'   => $alistFolder,
            'names' => $removeFiles,
        ];
        $response = $this->operationalService->delete($params, [], $timeout);
        $result   = json_decode($response, true);
        if (!isset($result['code']) || $result['code'] !== 200) {
            throw new AlistException(__FUNCTION__ . "异常：($response)");
        }
        return true;
    }

    /**
     * 新建文件夹
     * @param string $path
     * @return mixed
     */
    public function mkdir(string $path)
    {
        $params   = [
            'path' => $path,
        ];
        $response = $this->operationalService->mkdir($params);
        $result   = json_decode($response, true);
        if (!isset($result['code']) || $result['code'] !== 200) {
            throw new AlistException(__FUNCTION__ . "异常：($response)");
        }
        return true;
    }

    /**
     * 重命名
     * @param string $alistPath
     * @param string $name
     * @return mixed
     */
    public function rename(string $alistPath, string $name)
    {
        $params   = [
            'path' => $alistPath,
            'name' => $name,
        ];
        $response = $this->operationalService->rename($params);
        $result   = json_decode($response, true);
        if (!isset($result['code']) || $result['code'] !== 200) {
            throw new AlistException(__FUNCTION__ . "异常：($response)");
        }
        return true;
    }

    /**
     * 批量重命名
     * @param string $alistFolder
     * @param array $renameObjects
     * @return mixed
     */
    public function batchRename(string $alistFolder, array $renameObjects)
    {
        $params   = [
            'src_dir'        => $alistFolder,
            'rename_objects' => $renameObjects,
        ];
        $response = $this->operationalService->batchRename($params);
        $result   = json_decode($response, true);
        if (!isset($result['code']) || $result['code'] !== 200) {
            throw new AlistException(__FUNCTION__ . "异常：($response)");
        }
        return true;
    }

    /**
     * 移动文件
     * @param string $oldFolder
     * @param string $newFolder
     * @param array $moveFiles
     * @return mixed
     */
    public function move(string $oldFolder, string $newFolder, array $moveFiles)
    {
        $params   = [
            'src_dir' => $oldFolder,
            'dst_dir' => $newFolder,
            'names'   => $moveFiles,
        ];
        $response = $this->operationalService->move($params);
        $result   = json_decode($response, true);
        if (!isset($result['code']) || $result['code'] !== 200) {
            throw new AlistException(__FUNCTION__ . "异常：($response)");
        }
        return true;
    }

    /**
     * 聚合移动
     * @param string $oldFolder
     * @param string $newFolder
     * @return mixed
     */
    public function recursiveMove(string $oldFolder, string $newFolder)
    {
        $params   = [
            'src_dir' => $oldFolder,
            'dst_dir' => $newFolder,
        ];
        $response = $this->operationalService->recursiveMove($params);
        $result   = json_decode($response, true);
        if (!isset($result['code']) || $result['code'] !== 200) {
            throw new AlistException(__FUNCTION__ . "异常：($response)");
        }
        return true;
    }

    /**
     * 删除空文件夹
     * @param string $alistFolder
     * @return mixed
     */
    public function removeEmptyDirectory(string $alistFolder)
    {
        $params   = [
            'src_dir' => $alistFolder
        ];
        $response = $this->operationalService->removeEmptyDirectory($params);
        $result   = json_decode($response, true);
        if (!isset($result['code']) || $result['code'] !== 200) {
            throw new AlistException(__FUNCTION__ . "异常：($response)");
        }
        return true;
    }


    /**
     * bt下载
     * @param string $alistFolder
     * @param array $urls
     * @return mixed
     */
    public function downloadFileByBit(string $alistFolder, array $urls)
    {
        $params   = [
            'path'          => $alistFolder,
            'urls'          => $urls,
            'tool'          => 'qBittorrent',
            'delete_policy' => 'delete_on_upload_succeed',
        ];
        $response = $this->downloadService->downloadFile($params);
        $result   = json_decode($response, true);
        if (!isset($result['code']) || $result['code'] !== 200) {
            throw new AlistException(__FUNCTION__ . "异常：($response)");
        }
        return $result['data'];
    }

    /**
     * aria2下载
     * @param string $alistFolder
     * @param array $urls
     * @return mixed
     */
    public function downloadFileByAria2(string $alistFolder, array $urls)
    {
        $params   = [
            'path'          => $alistFolder,
            'urls'          => $urls,
            'tool'          => 'aria2',
            'delete_policy' => 'delete_on_upload_succeed',
        ];
        $response = $this->downloadService->downloadFile($params);
        $result   = json_decode($response, true);
        if (!isset($result['code']) || $result['code'] !== 200) {
            throw new AlistException(__FUNCTION__ . "异常：($response)");
        }
        return $result['data'];
    }


}
