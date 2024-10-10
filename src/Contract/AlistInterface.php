<?php
declare(strict_types=1);

namespace Exewen\Alist\Contract;

use Exewen\Http\Constants\HttpEnum;

interface AlistInterface
{
    # 权限
    public function getToken(string $clientId, string $clientSecret);

    # 查询
    public function getList(string $path, int $page = 1, int $limit = 20, bool $refresh = false, string $password = '');

    public function getListDetail(string $path, int $page = 1, int $limit = 20, bool $refresh = false, string $password = '');

    public function getListDirs(string $path, string $password = '');

    # 操作
    public function upload(string $filePath, string $alistFolder, string $type = HttpEnum::TYPE_MULTIPART);

    public function delete(string $alistFolder, array $removeFiles);

    public function mkdir(string $path);

    public function rename(string $alistPath, string $name);

    public function batchRename(string $alistFolder, array $renameObjects);

    public function move(string $oldFolder, string $newFolder, array $moveFiles);

    public function recursiveMove(string $oldFolder, string $newFolder);

    public function removeEmptyDirectory(string $alistFolder);

    # bt
    public function downloadFileByBit(string $alistFolder, array $urls);

    public function downloadFileByAria2(string $alistFolder, array $urls);

}