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
        $result = AlistFacade::getList($this->testAlistPath);
        $this->assertNotEmpty($result);
    }

    public function testGetListDetail()
    {
        $result = AlistFacade::getListDetail($this->testAlistPath);
        $this->assertNotEmpty($result);
    }

    public function testGetListDirs()
    {
        $result = AlistFacade::getListDirs($this->testAlistPath);
        $this->assertNotEmpty($result);
    }


}