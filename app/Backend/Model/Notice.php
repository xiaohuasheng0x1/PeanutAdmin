<?php

declare (strict_types=1);
namespace App\Backend\Model;

use App\Common\PaModel;
use Hyperf\Database\Model\SoftDeletes;

/**
 * @property int $id 主键
 * @property int $message_id 消息ID
 * @property string $title 标题
 * @property int $type 公告类型（1通知 2公告）
 * @property string $content 公告内容
 * @property int $click_num 浏览次数
 * @property int $created_by 创建者
 * @property int $updated_by 更新者
 * @property \Carbon\Carbon $created_at 创建时间
 * @property \Carbon\Carbon $updated_at 更新时间
 * @property string $deleted_at 删除时间
 * @property string $remark 备注
 */
class Notice extends PaModel
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected ?string $table = 'notice';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected array $fillable = ['id', 'message_id', 'title', 'type', 'content', 'click_num', 'created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at', 'remark'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected array $casts = ['id' => 'integer', 'message_id' => 'integer', 'type' => 'integer', 'click_num' => 'integer', 'created_by' => 'integer', 'updated_by' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}