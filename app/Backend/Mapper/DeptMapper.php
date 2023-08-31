<?php

declare(strict_types = 1);
namespace App\Backend\Mapper;


use App\Backend\Model\Dept;
use App\Common\Abstracts\AbstractMapper;
use App\Common\Annotation\Transaction;
use App\Common\Exception\PaException;
use App\Common\PaCollection;
use Hyperf\Database\Model\Builder;
use Hyperf\DbConnection\Db;

class DeptMapper extends AbstractMapper
{
    /**
     * @var Dept
     */
    public $model;

    public function assignModel()
    {
        $this->model = Dept::class;
    }

    /**
     * 获取前端选择树
     * @return array
     */
    public function getSelectTree(): array
    {
        $treeData = $this->model::query()->select(['id', 'parent_id', 'id AS value', 'name AS label'])
            ->where('status', $this->model::ENABLE)
            ->orderBy('parent_id')
            ->orderBy('sort', 'desc')
            ->userDataScope()
            ->get()->toArray();
        return (new PaCollection())->toTree($treeData, $treeData[0]['parent_id'] ?? 0);
    }

    /**
     * 获取部门领导列表
     * @param array|null $params
     * @return array
     */
    public function getLeaderList(?array $params = null): array
    {
        if (empty($params['dept_id'])) {
            throw new PaException('缺少部门ID', 500);
        }
        $query = Db::table('user as u')
            ->join('dept_leader as dl', 'u.id', '=', 'dl.user_id')
            ->where('dl.dept_id', '=', $params['dept_id']);

        if (!empty($params['username'])) {
            $query->where('u.username', 'like', '%' . $params['username'] . '%');
        }

        if (!empty($params['nickname'])) {
            $query->where('u.nickname', 'like', '%' . $params['nickname'] . '%');
        }

        if (!empty($params['status'])) {
            $query->where('u.status', $params['status']);
        }

        return $this->setPaginate(
            $query->paginate(
            (int) $params['pageSize'] ?? $this->model::PAGE_SIZE, ['u.*', 'dl.created_at as leader_add_time'], 'page', (int) $params['page'] ?? 1
            )
        );
    }

    /**
     * 新增部门领导
     * @param int $id
     * @param array $users
     * @return bool
     */
    #[Transaction]
    public function addLeader(int $id, array $users): bool
    {
        $model = $this->model::find($id, ['id']);
        foreach ($users as $key => $user) {
            if (Db::table('dept_leader')->where('dept_id', $id)->where('user_id', $user['user_id'])->exists()) {
                unset($users[$key]);
            }
        }
        count($users) > 0 && $model->leader()->sync($users, false);
        return true;
    }

    /**
     * 删除部门领导
     * @param int $id
     * @param array $users
     * @return bool
     */
    #[Transaction]
    public function delLeader(int $id, array $users): bool
    {
        $model = $this->model::find($id, ['id']);
        count($users) > 0 && $model->leader()->detach($users);
        return true;
    }

    /**
     * 查询部门名称
     * @param array|null $ids
     * @return array
     */
    public function getDeptName(array $ids = null): array
    {
        return $this->model::withTrashed()->whereIn('id', $ids)->pluck('name')->toArray();
    }

    /**
     * @param int $id
     * @return bool
     */
    public function checkChildrenExists(int $id): bool
    {
        return $this->model::withTrashed()->where('parent_id', $id)->exists();
    }

    /**
     * 搜索处理器
     * @param Builder $query
     * @param array $params
     * @return Builder
     */
    public function handleSearch(Builder $query, array $params): Builder
    {
        if (!empty($params['status'])) {
            $query->where('status', $params['status']);
        }

        if (!empty($params['name'])) {
            $query->where('name', 'like', '%'.$params['name'].'%');
        }

        if (!empty($params['leader'])) {
            $query->where('leader', $params['leader']);
        }

        if (!empty($params['phone'])) {
            $query->where('phone', $params['phone']);
        }

        if (!empty($params['created_at']) && is_array($params['created_at']) && count($params['created_at']) == 2) {
            $query->whereBetween(
                'created_at',
                [ $params['created_at'][0] . ' 00:00:00', $params['created_at'][1] . ' 23:59:59' ]
            );
        }
        return $query;
    }
}