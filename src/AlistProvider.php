<?php
declare(strict_types=1);

namespace Exewen\Alist;

use Exewen\Di\ServiceProvider;
use Exewen\Alist\Contract\AlistInterface;

class AlistProvider extends ServiceProvider
{

    /**
     * 服务注册
     * @return void
     */
    public function register()
    {
        $this->container->singleton(AlistInterface::class);
    }

}