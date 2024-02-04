<?php

declare(strict_types=1);


namespace App\System\Controller\Monitor;

use App\System\Service\SystemUserService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Easy\Annotation\Auth;
use Easy\Annotation\Permission;
use Easy\EasyController;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\SimpleCache\InvalidArgumentException;

/**
 * 在线用户监控
 * Class OnlineUserMonitorController.
 */
#[Controller(prefix: 'system/onlineUser'), Auth]
class OnlineUserMonitorController extends EasyController
{
    #[Inject]
    protected SystemUserService $service;

    /**
     * 获取在线用户列表.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[GetMapping('index'), Permission('system:onlineUser, system:onlineUser:index')]
    public function getPageList(): ResponseInterface
    {
        return $this->success($this->service->getOnlineUserPageList($this->request->all()));
    }

    /**
     * 强退用户.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws InvalidArgumentException
     */
    #[PostMapping('kick'), Permission('system:onlineUser:kick')]
    public function kickUser(): ResponseInterface
    {
        return $this->service->kickUser((string) $this->request->input('id')) ?
            $this->success() : $this->error();
    }
}
