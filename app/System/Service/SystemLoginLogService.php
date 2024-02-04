<?php

declare(strict_types=1);


namespace App\System\Service;

use App\System\Mapper\SystemLoginLogMapper;
use Easy\Abstracts\AbstractService;

/**
 * 登录日志业务
 * Class SystemLoginLogService.
 */
class SystemLoginLogService extends AbstractService
{
    /**
     * @var SystemLoginLogMapper
     */
    public $mapper;

    public function __construct(SystemLoginLogMapper $mapper)
    {
        $this->mapper = $mapper;
    }
}
