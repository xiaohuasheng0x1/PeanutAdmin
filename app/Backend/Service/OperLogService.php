<?php

declare(strict_types = 1);
namespace App\Backend\Service;


use App\Backend\Mapper\OperLogMapper;
use App\Common\Abstracts\AbstractService;

class OperLogService extends AbstractService
{
    public $mapper;

    public function __construct(OperLogMapper $mapper)
    {
        $this->mapper = $mapper;
    }
}