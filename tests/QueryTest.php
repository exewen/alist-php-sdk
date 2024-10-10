<?php
declare(strict_types=1);

namespace ExewenTest\Alist;

use Exewen\Alist\AlistFacade;

class QueryTest extends Base
{
    private $testAlistPath;
    private $testFile;

    public function __construct()
    {
        parent::__construct();
        $this->testFile      = getenv('ALIST_TEST_FILE');
        $this->testAlistPath = getenv('ALIST_ALIST_PATH');
    }

    public function testGetList()
    {
        $response = AlistFacade::getList($this->testAlistPath);
        echo __FUNCTION__ . ' ' . $response['message'] . PHP_EOL;
        $this->assertNotEmpty($response);
    }

    public function testGetListDetail()
    {
        $response = AlistFacade::getListDetail($this->testAlistPath);
        echo __FUNCTION__ . ' ' . $response['message'] . PHP_EOL;
        $this->assertNotEmpty($response);
    }

    public function testGetListDirs()
    {
        $response = AlistFacade::getListDirs($this->testAlistPath);
        echo __FUNCTION__ . ' ' . $response['message'] . PHP_EOL;
        $this->assertNotEmpty($response);
    }


}