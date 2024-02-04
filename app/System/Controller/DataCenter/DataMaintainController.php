<?php

declare(strict_types=1);


namespace App\System\Controller\DataCenter;

use App\System\Service\DataMaintainService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Easy\Annotation\Auth;
use Easy\Annotation\OperationLog;
use Easy\Annotation\Permission;
use Easy\EasyController;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class DataMaintainController.
 */
#[Controller(prefix: 'system/dataMaintain'), Auth]
class DataMaintainController extends EasyController
{
    #[Inject]
    protected DataMaintainService $service;

    /**
     * 列表.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[GetMapping('index'), Permission('system:dataMaintain, system:dataMaintain:index')]
    public function index(): ResponseInterface
    {
        return $this->success($this->service->getPageList($this->request->all()));
    }

    /**
     * 详情.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[GetMapping('detailed'), Permission('system:dataMaintain:detailed')]
    public function detailed(): ResponseInterface
    {
        return $this->success($this->service->getColumnList($this->request->input('table', null)));
    }

    /**
     * 优化表.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[PostMapping('optimize'), Permission('system:dataMaintain:optimize'), OperationLog]
    public function optimize(): ResponseInterface
    {
        $tables = $this->request->input('tables', []);
        return $this->service->optimize($tables) ? $this->success() : $this->error();
    }

    /**
     * 清理表碎片.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[PostMapping('fragment'), Permission('system:dataMaintain:fragment'), OperationLog]
    public function fragment(): ResponseInterface
    {
        $tables = $this->request->input('tables', []);
        return $this->service->fragment($tables) ? $this->success() : $this->error();
    }
}
