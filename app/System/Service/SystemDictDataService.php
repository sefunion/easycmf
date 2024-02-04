<?php

declare(strict_types=1);


namespace App\System\Service;

use App\System\Mapper\SystemDictDataMapper;
use Hyperf\Cache\Annotation\Cacheable;
use Hyperf\Cache\Annotation\CacheEvict;
use Easy\Abstracts\AbstractService;
use Easy\Annotation\DependProxy;
use Easy\Interfaces\ServiceInterface\DictDataServiceInterface;
use Easy\EasyModel;

/**
 * 字典类型业务
 * Class SystemLoginLogService.
 */
#[DependProxy(values: [DictDataServiceInterface::class])]
class SystemDictDataService extends AbstractService implements DictDataServiceInterface
{
    /**
     * @var SystemDictDataMapper
     */
    public $mapper;

    public function __construct(SystemDictDataMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * 查询多个字典.
     */
    public function getLists(?array $params = null): array
    {
        if (! isset($params['codes'])) {
            return [];
        }

        $codes = explode(',', $params['codes']);
        $data = [];

        foreach ($codes as $code) {
            $data[$code] = $this->getList(['code' => $code]);
        }

        return $data;
    }

    /**
     * 查询一个字典.
     */
    #[Cacheable(prefix: 'system:dict:data', ttl: 600, listener: 'system-dict-update', value: '_#params.code')]
    public function getList(?array $params = null, bool $isScope = false): array
    {
        $args = [
            'select' => ['id', 'label as title', 'value as key'],
            'status' => EasyModel::ENABLE,
            'orderBy' => 'sort',
            'orderType' => 'desc',
        ];
        return $this->mapper->getList(array_merge($args, $params), $isScope);
    }

    /**
     * 清除缓存.
     */
    #[CacheEvict(prefix: 'system:dict:data', all: true)]
    public function clearCache(): bool
    {
        return true;
    }
}
