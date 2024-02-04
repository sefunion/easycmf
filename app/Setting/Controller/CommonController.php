<?php

declare(strict_types=1);


namespace App\Setting\Controller;

use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Easy\Annotation\Auth;
use Easy\EasyController;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * setting 公共方法控制器
 * Class CommonController.
 */
#[Controller(prefix: 'setting/common'), Auth]
class CommonController extends EasyController
{
    /**
     * 返回模块信息及表前缀
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[GetMapping('getModuleList')]
    public function getModuleList(): ResponseInterface
    {
        return $this->success($this->easy->getModuleInfo());
    }
}
