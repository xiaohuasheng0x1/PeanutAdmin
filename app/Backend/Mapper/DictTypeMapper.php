<?php
declare(strict_types=1);
namespace App\Backend\Mapper;

use App\Backend\Model\DictData;
use App\Backend\Model\DictType;
use App\Common\Abstracts\AbstractMapper;
use App\Common\Annotation\Transaction;
use Hyperf\Database\Model\Builder;

/**
 * Class UserMapper
 * @package App\System\Mapper
 */
class DictTypeMapper extends AbstractMapper
{
    /**
     * @var DictType
     */
    public $model;

    public function assignModel()
    {
        $this->model = DictType::class;
    }

    /**
     * @param int $id
     * @param array $data
     * @return bool
     */
    #[Transaction]
    public function update(int $id, array $data): bool
    {
        parent::update($id, $data);
        DictData::where('type_id', $id)->update(['code' => $data['code']]) > 0;
        return true;
    }

    /**
     * @param array $ids
     * @return bool
     */
    #[Transaction]
    public function realDelete(array $ids): bool
    {
        foreach ($ids as $id) {
            $model = $this->model::withTrashed()->find($id);
            if ($model) {
                $model->dictData()->forceDelete();
                $model->forceDelete();
            }
        }
        return true;
    }

    /**
     * 搜索处理器
     * @param Builder $query
     * @param array $params
     * @return Builder
     */
    public function handleSearch(Builder $query, array $params): Builder
    {
        if (!empty($params['code'])) {
            $query->where('code', 'like', '%'.$params['code'].'%');
        }
        if (!empty($params['name'])) {
            $query->where('name', 'like', '%'.$params['name'].'%');
        }
        if (!empty($params['status'])) {
            $query->where('status', $params['status']);
        }
        return $query;
    }
}