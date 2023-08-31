<?php

declare(strict_types=1);
namespace App\Backend\Service;

use App\Backend\Mapper\DictTypeMapper;
use App\Common\Abstracts\AbstractService;

/**
 * 字典类型业务
 * Class LoginLogService
 * @package Backend\System\Service
 */
class DictTypeService extends AbstractService
{
    /**
     * @var DictTypeMapper
     */
    public $mapper;


    public function __construct(DictTypeMapper $mapper)
    {
        $this->mapper = $mapper;
    }
}
