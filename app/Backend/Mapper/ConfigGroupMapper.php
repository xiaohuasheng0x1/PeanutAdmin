<?php

declare(strict_types=1);
namespace App\Backend\Mapper;

use App\Backend\Model\ConfigGroup;
use App\Common\Abstracts\AbstractMapper;

class ConfigGroupMapper extends AbstractMapper
{
    /**
     * @var ConfigGroup
     */
    public $model;

    public function assignModel()
    {
        $this->model = ConfigGroup::class;
    }

    /**
     * 删除组和所属配置
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function deleteGroupAndConfig(int $id): bool
    {
        /* @var $model ConfigGroup */
        $model = $this->read($id);
        $model->configs()->delete();
        return $model->delete();
    }
}