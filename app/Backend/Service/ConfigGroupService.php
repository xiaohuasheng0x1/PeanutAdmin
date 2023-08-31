<?php

declare(strict_types=1);
namespace App\Backend\Service;


use App\Backend\Mapper\ConfigGroupMapper;
use App\Common\Abstracts\AbstractService;
use App\Common\Annotation\Transaction;

class ConfigGroupService extends AbstractService
{
    /**
     * @var ConfigGroupMapper
     */
    public $mapper;

    /**
     * ConfigGroupService constructor.
     * @param ConfigGroupMapper $mapper
     */
    public function __construct(ConfigGroupMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * 删除配置组和其所属配置
     * @param int $id
     * @return bool
     */
    #[Transaction]
    public function deleteConfigGroup(int $id): bool
    {
        return $this->mapper->deleteGroupAndConfig($id);
    }
}