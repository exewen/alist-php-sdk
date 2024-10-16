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
        AlistFacade::mkdir($this->testAlistPath . '/测试/上传');
        AlistFacade::mkdir($this->testAlistPath . '/测试/移动');
        AlistFacade::mkdir($this->testAlistPath . '/测试/删除');
        $result = AlistFacade::mkdir($this->testAlistPath . '/测试/空');
        $this->assertTrue($result);
    }

    public function testUpload()
    {
        AlistFacade::upload($this->testFile, $this->testAlistPath . '/测试/上传');
        $result = AlistFacade::upload($this->testFile, $this->testAlistPath . '/测试/删除');
        $this->assertTrue($result);
    }


    public function testDelete()
    {
        $removeFile = ['安全图片.jpg'];
        $result     = AlistFacade::delete($this->testAlistPath . '/测试/删除', $removeFile);
        $this->assertTrue($result);
    }

    /**
     * 重命名
     * @return void
     */
    public function testRename()
    {
        $oldName = '安全图片.jpg';
        $newName = '安全图片2.jpg';
        $result  = AlistFacade::rename($this->testAlistPath . '/测试/上传/' . $oldName, $newName);
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
                'src_name' => '安全图片2.jpg',
                'new_name' => '安全图片3.jpg',
            ]
        ];
        $result        = AlistFacade::batchRename($this->testAlistPath . '/测试/上传/', $renameObjects);
        sleep(1);
        $this->assertTrue($result);
    }

    /**
     * 移动
     * @return void
     */
    public function testMove()
    {
        $oldFolder = $this->testAlistPath . '/测试/上传/';
        $newFolder = $this->testAlistPath . '/测试/删除/';
        $moveFiles = ['安全图片3.jpg'];
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
        $oldFolder = $this->testAlistPath . '/测试/删除/';
        $newFolder = $this->testAlistPath . '/测试/移动/';
        $result    = AlistFacade::recursiveMove($oldFolder, $newFolder);
        sleep(1);
        $this->assertTrue($result);
    }

    /**
     * 清理空文件夹
     * 测完成 剩余  (移动->图片3)
     * @return void
     */
    public function testRemoveEmptyDirectory()
    {
        $result = AlistFacade::removeEmptyDirectory($this->testAlistPath . '/测试');
        $this->assertTrue($result);
    }


}