<?php

declare(strict_types=1);


namespace App\System\Controller\Monitor;

use App\System\Service\ServerMonitorService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Easy\Annotation\Auth;
use Easy\Annotation\Permission;
use Easy\EasyController;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class ServerMonitorController.
 */
#[Controller(prefix: 'system/server'), Auth]
class ServerMonitorController extends EasyController
{
    #[Inject]
    protected ServerMonitorService $service;

    /**
     * 获取服务器信息.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[GetMapping('monitor'), Permission('system:monitor:server')]
    public function getServerInfo(): ResponseInterface
    {
        return $this->success([
            'cpu' => $this->service->getCpuInfo(),
            'memory' => $this->service->getMemInfo(),
            'phpenv' => $this->service->getPhpAndEnvInfo(),
            'disk' => $this->service->getDiskInfo(),
        ]);
    }
}
