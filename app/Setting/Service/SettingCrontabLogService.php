<?php

declare(strict_types=1);


namespace App\Setting\Service;

use App\Setting\Mapper\SettingCrontabLogMapper;
use Easy\Abstracts\AbstractService;
use Easy\Annotation\DependProxy;
use Easy\Interfaces\ServiceInterface\CrontabLogServiceInterface;

#[DependProxy(values: [CrontabLogServiceInterface::class])]
class SettingCrontabLogService extends AbstractService implements CrontabLogServiceInterface
{
    /**
     * @var SettingCrontabLogMapper
     */
    public $mapper;

    public function __construct(SettingCrontabLogMapper $mapper)
    {
        $this->mapper = $mapper;
    }
}
