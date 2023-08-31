<?php


namespace App\Backend\Service;


use App\Backend\Mapper\CrontabLogMapper;
use App\Common\Abstracts\AbstractService;

class CrontabLogService extends AbstractService
{
    /**
     * @var CrontabLogMapper
     */
    public $mapper;

    public function __construct(CrontabLogMapper $mapper)
    {
        $this->mapper = $mapper;
    }
}