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
        $response = AlistFacade::mkdir($this->testAlistPath . '/测试/空');
        echo __FUNCTION__ . ' ' . $response['message'] . PHP_EOL;
        $this->assertNotEmpty($response);
    }

    public function testUpload()
    {
        AlistFacade::upload($this->testFile, $this->testAlistPath . '/测试/上传');
        $response = AlistFacade::upload($this->testFile, $this->testAlistPath . '/测试/删除');
        echo __FUNCTION__ . ' ' . $response['message'] . PHP_EOL;
        $this->assertNotEmpty($response);
    }

    public function testDelete()
    {
        $removeFile = ['安全图片.jpg'];
        $response   = AlistFacade::delete($this->testAlistPath . '/测试/删除', $removeFile);
        echo __FUNCTION__ . ' ' . $response['message'] . PHP_EOL;
        $this->assertNotEmpty($response);
    }


    public function testRename()
    {
        $oldName  = '安全图片.jpg';
        $newName  = '安全图片2.jpg';
        $response = AlistFacade::rename($this->testAlistPath . '/测试/上传/' . $oldName, $newName);
        echo __FUNCTION__ . ' ' . $response['message'] . PHP_EOL;
        $this->assertNotEmpty($response);
    }

    public function testBatchRename()
    {
        $renameObjects = [
            [
                'src_name' => '安全图片2.jpg',
                'new_name' => '安全图片3.jpg',
            ]
        ];
        $response      = AlistFacade::batchRename($this->testAlistPath . '/测试/上传/', $renameObjects);
        echo __FUNCTION__ . ' ' . $response['message'] . PHP_EOL;
        $this->assertNotEmpty($response);
    }

    public function testMove()
    {
        $oldFolder = $this->testAlistPath . '/测试/上传/';
        $newFolder = $this->testAlistPath . '/测试/删除/';
        $moveFiles = ['安全图片3.jpg'];
        $response  = AlistFacade::move($oldFolder, $newFolder, $moveFiles);
        echo __FUNCTION__ . ' ' . $response['message'] . PHP_EOL;
        $this->assertNotEmpty($response);
    }

    public function testRecursiveMove()
    {
        $oldFolder = $this->testAlistPath . '/测试/删除/';
        $newFolder = $this->testAlistPath . '/测试/移动/';
        $response  = AlistFacade::recursiveMove($oldFolder, $newFolder);
        echo __FUNCTION__ . ' ' . $response['message'] . PHP_EOL;
        $this->assertNotEmpty($response);
    }

    /**
     * 剩下 移动  图片3
     * @return void
     */
    public function testRemoveEmptyDirectory()
    {
        $response = AlistFacade::removeEmptyDirectory($this->testAlistPath . '/测试');
        echo __FUNCTION__ . ' ' . $response['message'] . PHP_EOL;
        $this->assertNotEmpty($response);
    }


}