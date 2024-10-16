<?php
declare(strict_types=1);

namespace Exewen\Alist;

use Exewen\Facades\Facade;
use Exewen\Http\Constants\HttpEnum;
use Exewen\Http\HttpProvider;
use Exewen\Logger\LoggerProvider;
use Exewen\Alist\Contract\AlistInterface;

/**
 * @method static void setAccessToken(string $accessToken) 设置token
 * @method static array getToken(string $username, string $password) 获取token
 * @method static array getList(string $path, int $page = 1, int $limit = 20, bool $refresh = false, string $password = '') 列出目录和文件
 * @method static array getListDirs(string $path, string $password = '') 只列出目录
 * @method static array getListDetail(string $path, int $page = 1, int $limit = 20, bool $refresh = false, string $password = '') 获取某个目录和文件信息
 * @method static bool upload(string $filePath, string $alistFolder, string $type = HttpEnum::TYPE_MULTIPART) 上传文件/流式上传文件
 * @method static bool delete(string $alistFolder, array $removeFiles) 删除文件或文件夹
 * @method static bool mkdir(string $path) 新建文件夹
 * @method static bool rename(string $alistPath, string $name) 重命名
 * @method static bool batchRename(string $alistFolder, array $renameObjects) 批量重命名 "rename_objects":[{"src_name":"a","new_name":"b",}]
 * @method static bool move(string $oldFolder, string $newFolder, array $moveFiles) 移动文件
 * @method static bool recursiveMove(string $oldFolder, string $newFolder) 聚合移动
 * @method static bool removeEmptyDirectory(string $alistFolder) 删除空文件夹
 * @method static array downloadFileByBit(string $alistFolder, array $urls) bt下载
 * @method static array downloadFileByAria2(string $alistFolder, array $urls) aria2下载
 */
class AlistFacade extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return AlistInterface::class;
    }

    public static function getProviders(): array
    {
        return [
            LoggerProvider::class,
            HttpProvider::class,
            AlistProvider::class
        ];
    }
}