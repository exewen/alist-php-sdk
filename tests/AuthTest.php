<?php
declare(strict_types=1);

namespace ExewenTest\Alist;

use Exewen\Alist\AlistFacade;

class AuthTest extends Base
{

    public function testToken()
    {
        $clientId     = getenv('ALIST_USERNAME');
        $clientSecret = getenv('ALIST_PASSWORD');
        $response     = AlistFacade::getToken($clientId, $clientSecret);
        echo $response['data']['token'] . PHP_EOL;
        $this->assertNotEmpty($response);
    }

}