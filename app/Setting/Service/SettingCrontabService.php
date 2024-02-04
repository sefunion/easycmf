<?php

declare(strict_types=1);


namespace App\Setting\Service;

use App\Setting\Mapper\SettingCrontabMapper;
use Hyperf\Cache\Annotation\Cacheable;
use Hyperf\Cache\Annotation\CacheEvict;
use Easy\Abstracts\AbstractService;
use Easy\Annotation\DeleteCache;
use Easy\Crontab\EasyCrontab;
use Easy\Crontab\EasyExecutor;
use Easy\EasyModel;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class SettingCrontabService extends AbstractService
{
    /**
     * @var SettingCrontabMapper
     */
    public $mapper;

    private EasyExecutor $easyExecutor;

    public function __construct(
        SettingCrontabMapper $mapper,
        EasyExecutor $easyExecutor
    ) {
        $this->mapper = $mapper;
        $this->easyExecutor = $easyExecutor;
    }

    /**
     * 保存.
     */
    public function save(array $data): int
    {
        return parent::save($data);
    }

    /**
     * 更新.
     */
    #[CacheEvict(prefix: 'setting:crontab:read', value: '_#{id}')]
    public function update(int $id, array $data): bool
    {
        return parent::update($id, $data);
    }

    #[CacheEvict(prefix: 'setting:crontab:read', all: true)]
    public function delete(array $ids): bool
    {
        return parent::delete($ids);
    }

    #[Cacheable(prefix: 'setting:crontab:read', value: '_#{id}', ttl: 600)]
    public function read(int $id, array $column = ['*']): ?EasyModel
    {
        return parent::read($id, $column);
    }

    /**
     * 立即执行一次定时任务
     * @param mixed $id
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function run($id): ?bool
    {
        $crontab = new EasyCrontab();
        $model = $this->read($id);
        $crontab->setCallback($model->target);
        $crontab->setType((string) $model->type);
        $crontab->setEnable(true);
        $crontab->setCrontabId($model->id);
        $crontab->setName($model->name);
        $crontab->setParameter($model->parameter ?: '');
        $crontab->setRule($model->rule);
        return $this->easyExecutor->execute($crontab, true);
    }

    #[DeleteCache('crontab')]
    public function changeStatus(int $id, string $value, string $filed = 'status'): bool
    {
        return parent::changeStatus($id, $value, $filed);
    }
}
