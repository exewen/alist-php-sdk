<?php
declare(strict_types=1);

namespace ExewenTest\Alist;

use Exewen\Alist\AlistFacade;

class OperationalTest extends Base
{
    private $testAlistPath;
    private $testFile;

    public function __construct()
    {
        parent::__construct();
        $this->testFile      = getenv('ALIST_TEST_FILE');
        $this->testAlistPath = getenv('ALIST_ALIST_PATH');
    }

    public function testMkdir()
    {
        AlistFacade::mkdir($this->testAlistPath . '/上传');
        AlistFacade::mkdir($this->testAlistPath . '/移动');
        AlistFacade::mkdir($this->testAlistPath . '/删除');
        $result = AlistFacade::mkdir($this->testAlistPath . '/空');
        $this->assertTrue($result);
    }

    public function testUpload()
    {
        AlistFacade::upload($this->testFile, $this->testAlistPath . '/上传');
        $result = AlistFacade::upload($this->testFile, $this->testAlistPath . '/删除');
        $this->assertTrue($result);
    }


    public function testDelete()
    {
        $removeFile = ['logo.jpeg'];
        $result     = AlistFacade::delete($this->testAlistPath . '/删除', $removeFile);
        $this->assertTrue($result);
    }

    /**
     * 重命名
     * @return void
     */
    public function testRename()
    {
        $oldName = 'logo.jpeg';
        $newName = 'logo_rename.jpeg';
        $result  = AlistFacade::rename($this->testAlistPath . '/上传/' . $oldName, $newName);
        sleep(1);
        $this->assertTrue($result);
    }

    /**
     * 批量重命名
     * @return void
     */
    public function testBatchRename()
    {
        $renameObjects = [
            [
                'src_name' => 'logo_rename.jpeg',
                'new_name' => 'logo_batch_rename.jpeg',
            ]
        ];
        $result        = AlistFacade::batchRename($this->testAlistPath . '/上传/', $renameObjects);
        sleep(1);
        $this->assertTrue($result);
    }

    /**
     * 移动
     * @return void
     */
    public function testMove()
    {
        $oldFolder = $this->testAlistPath . '/上传/';
        $newFolder = $this->testAlistPath . '/删除/';
        $moveFiles = ['logo_batch_rename.jpeg'];
        $result    = AlistFacade::move($oldFolder, $newFolder, $moveFiles);
        sleep(1);
        $this->assertTrue($result);

    }

    /**
     * 聚合移动
     * @return void
     */
    public function testRecursiveMove()
    {
        $oldFolder = $this->testAlistPath . '/删除/';
        $newFolder = $this->testAlistPath . '/移动/';
        $result    = AlistFacade::recursiveMove($oldFolder, $newFolder);
        sleep(1);
        $this->assertTrue($result);
    }

    /**
     * 清理空文件夹
     * 测完成 剩余  (移动->logo_batch_rename.jpeg)
     * @return void
     */
    public function testRemoveEmptyDirectory()
    {
        $result = AlistFacade::removeEmptyDirectory($this->testAlistPath);
        $this->assertTrue($result);
    }


}