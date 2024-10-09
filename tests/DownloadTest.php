<?php
declare(strict_types=1);

namespace ExewenTest\Alist;

use Exewen\Alist\AlistFacade;

class DownloadTest extends Base
{
    private $testAlistPath;

    public function __construct()
    {
        parent::__construct();
        $this->testAlistPath = getenv('ALIST_ALIST_PATH');
    }

    public function testDownloadFileByBit()
    {
        $urls     = [
            "magnet:?xt=urn:btih:5cee5d30a0d18586dbbd9d1698a320a1d7da2c73&dn=[www.dbmp4.com]遮天.第76话.HD1080p.mp4&tr=https://tracker.iriseden.fr:443/announce&tr=https://tr.highstar.shop:443/announce&tr=https://tr.fuckbitcoin.xyz:443/announce&tr=https://tr.doogh.club:443/announce&tr=https://tr.burnabyhighstar.com:443/announce&tr=https://t.btcland.xyz:443/announce&tr=http://vps02.net.orel.ru:80/announce&tr=https://tracker.kuroy.me:443/announce&tr=http://tr.cili001.com:8070/announce&tr=http://t.overflow.biz:6969/announce&tr=http://t.nyaatracker.com:80/announce&tr=http://open.acgnxtracker.com:80/announce&tr=http://nyaa.tracker.wf:7777/announce&tr=http://home.yxgz.vip:6969/announce&tr=http://buny.uk:6969/announce&tr=https://tracker.tamersunion.org:443/announce&tr=https://tracker.nanoha.org:443/announce&tr=https://tracker.loligirl.cn:443/announce&tr=udp://bubu.mapfactor.com:6969/announce&tr=http://share.camoe.cn:8080/announce&tr=udp://movies.zsw.ca:6969/announce&tr=udp://ipv4.tracker.harry.lu:80/announce&tr=udp://tracker.sylphix.com:6969/announce&tr=http://95.216.22.207:9001/announce"
        ];
        $response = AlistFacade::downloadFileByBit($this->testAlistPath, $urls);
        echo __FUNCTION__ . ' ' . $response['message'] . PHP_EOL;
        $this->assertNotEmpty($response);
    }

    public function testDownloadFileByAria2()
    {
        $urls     = [
            "https://dldir1.qq.com/qqfile/qq/QQNT/Windows/QQ_9.9.15_240927_x64_01.exe"
        ];
        $response = AlistFacade::downloadFileByAria2($this->testAlistPath, $urls);
        echo __FUNCTION__ . ' ' . $response['message'] . PHP_EOL;
        $this->assertNotEmpty($response);
    }


}