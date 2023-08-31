<?php
declare(strict_types=1);
namespace App\Backend\Request;

use App\Common\PaFormRequest;

class NoticeRequest extends PaFormRequest
{
    /**
     * 公共规则
     */
    public function commonRules(): array
    {
        return [];
    }

    /**
     * 新增数据验证规则
     * return array
     */
    public function saveRules(): array
    {
        return [
            'title' => 'required',
            'type' => 'required',
            'content' => 'required',
        ];
    }

    /**
     * 更新数据验证规则
     * return array
     */
    public function updateRules(): array
    {
        return [
            'title' => 'required',
            'type' => 'required',
            'content' => 'required',
        ];
    }

    /**
     * 字段映射名称
     * return array
     */
    public function attributes(): array
    {
        return [
            'title' => '公告标题',
            'type' => '公告类型',
            'content' => '公告内容',
        ];
    }

}