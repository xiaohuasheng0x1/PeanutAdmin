<?php

declare(strict_types=1);
namespace App\Backend\Service;

use App\Backend\Mapper\LoginLogMapper;
use App\Common\Abstracts\AbstractService;

/**
 * 登录日志业务
 * Class LoginLogService
 * @package Backend\System\Service
 */
class LoginLogService extends AbstractService
{
    /**
     * @var LoginLogMapper
     */
    public $mapper;

    public function __construct(LoginLogMapper $mapper)
    {
        $this->mapper = $mapper;
    }
}