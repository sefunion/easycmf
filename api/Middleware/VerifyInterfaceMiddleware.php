<?php


declare(strict_types=1);


namespace Api\Middleware;

use App\System\Model\SystemApi;
use App\System\Service\SystemApiService;
use App\System\Service\SystemAppService;
use Hyperf\Context\Context;
use Hyperf\Di\Annotation\Inject;
use Easy\Annotation\Api\MApi;
use Easy\Annotation\Api\MApiCollector;
use Easy\Event\ApiAfter;
use Easy\Event\ApiBefore;
use Easy\Exception\NormalStatusException;
use Easy\Helper\EasyCode;
use Easy\EasyRequest;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\SimpleCache\InvalidArgumentException;

class VerifyInterfaceMiddleware implements MiddlewareInterface
{
    /**
     * 事件调度器.
     */
    #[Inject]
    protected EventDispatcherInterface $evDispatcher;

    /**
     * 验证检查接口.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws InvalidArgumentException
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return $this->run($request, $handler);
    }

    /**
     * 访问接口鉴权处理.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws InvalidArgumentException
     */
    protected function auth(ServerRequestInterface $request): int
    {
        try {
            /* @var $service SystemAppService */
            $service = container()->get(SystemAppService::class);
            $queryParams = $request->getQueryParams();
            $apiData = $this->_getApiData();
            switch ($apiData['auth_mode']) {
                case MApi::AUTH_MODE_EASY:
                    if (empty($queryParams['app_id'])) {
                        return EasyCode::API_APP_ID_MISSING;
                    }
                    if (empty($queryParams['identity'])) {
                        return EasyCode::API_IDENTITY_MISSING;
                    }
                    return $service->verifyEasyMode($queryParams['app_id'], $queryParams['identity'], $apiData);
                case MApi::AUTH_MODE_NORMAL:
                    if (empty($queryParams['access_token'])) {
                        return EasyCode::API_ACCESS_TOKEN_MISSING;
                    }
                    return $service->verifyNormalMode($queryParams['access_token'], $apiData);
                default:
                    throw new \RuntimeException();
            }
        } catch (\Throwable $e) {
            throw new NormalStatusException(t('easycmf.api_auth_exception'), EasyCode::API_AUTH_EXCEPTION);
        }
    }

    /**
     * API常规检查.
     * @param mixed $request
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    protected function apiModelCheck($request): ServerRequestInterface
    {
        // 先对注解检测，有直接放行
        $apiData = MApiCollector::getApiInfos();
        $easyRequest = container()->get(EasyRequest::class);

        if (isset($apiData[$easyRequest->route('method')])) {
            $apiModel = $apiData[$easyRequest->route('method')];

            // 检查接口是否停用
            if ($apiModel['status'] == SystemApi::DISABLE) {
                throw new NormalStatusException(t('easycmf.api_stop'), EasyCode::RESOURCE_STOP);
            }

            // 检查接口请求方法
            if ($apiModel['request_mode'] !== MApi::METHOD_ALL && $request->getMethod()[0] !== $apiModel['request_mode']) {
                throw new NormalStatusException(
                    t('easycmf.not_allow_method', ['method' => $request->getMethod()]),
                    EasyCode::METHOD_NOT_ALLOW
                );
            }

            $this->_setApiData($apiModel);

            // 合并入参
            return $request->withParsedBody(array_merge(
                $request->getParsedBody(),
                ['apiData' => $apiModel]
            ));
        }

        $service = container()->get(SystemApiService::class);
        $apiModel = $service->mapper->one(function ($query) {
            $request = container()->get(EasyRequest::class);
            $query->where('access_name', $request->route('method'));
        });

        // 检查接口是否存在
        if (! $apiModel) {
            throw new NormalStatusException(t('easycmf.not_found'), EasyCode::NOT_FOUND);
        }

        // 检查接口是否停用
        if ($apiModel['status'] == SystemApi::DISABLE) {
            throw new NormalStatusException(t('easycmf.api_stop'), EasyCode::RESOURCE_STOP);
        }

        // 检查接口请求方法
        if ($apiModel['request_mode'] !== MApi::METHOD_ALL && $request->getMethod()[0] !== $apiModel['request_mode']) {
            throw new NormalStatusException(
                t('easycmf.not_allow_method', ['method' => $request->getMethod()]),
                EasyCode::METHOD_NOT_ALLOW
            );
        }

        $this->_setApiData($apiModel->toArray());

        // 合并入参
        return $request->withParsedBody(array_merge(
            $request->getParsedBody(),
            ['apiData' => $apiModel->toArray()]
        ));
    }

    /**
     * 运行.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws InvalidArgumentException
     */
    protected function run(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->evDispatcher->dispatch(new ApiBefore());

        $request = $this->apiModelCheck($request);

        if (($code = $this->auth($request)) !== EasyCode::API_VERIFY_PASS) {
            throw new NormalStatusException(t('easycmf.api_auth_fail'), $code);
        }

        $result = $handler->handle($request);

        $event = new ApiAfter($this->_getApiData(), $result);
        $this->evDispatcher->dispatch($event);

        return $event->getResult();
    }

    /**
     * 设置协程上下文.
     */
    private function _setApiData(array $data)
    {
        Context::set('apiData', $data);
    }

    /**
     * 获取协程上下文.
     */
    private function _getApiData(): array
    {
        return Context::get('apiData', []);
    }
}
