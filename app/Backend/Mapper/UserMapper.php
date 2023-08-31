<?php

declare(strict_types=1);
namespace App\Backend\Mapper;

use App\Backend\Model\Dept;
use App\Backend\Model\User;
use App\Common\Abstracts\AbstractMapper;
use App\Common\Annotation\Transaction;
use App\Common\PaModel;
use Hyperf\Database\Model\Builder;
use Hyperf\DbConnection\Db;

/**
 * Class UserMapper
 * @package App\System\Mapper
 */
class UserMapper extends AbstractMapper
{
    /**
     * @var User
     */
    public $model;

    public function assignModel()
    {
        $this->model = User::class;
    }

    /**
     * 通过用户名检查用户
     * @param string $username
     * @return Builder|\Hyperf\Database\Model\Model
     */
    public function checkUserByUsername(string $username)
    {
        return $this->model::query()->where('username', $username)->firstOrFail();
    }

    /**
     * 通过用户名检查是否存在
     * @param string $username
     * @return bool
     */
    public function existsByUsername(string $username): bool
    {
        return $this->model::query()->where('username', $username)->exists();
    }

    /**
     * 检查用户密码
     * @param String $password
     * @param string $hash
     * @return bool
     */
    public function checkPass(String $password, string $hash): bool
    {
        return $this->model::passwordVerify($password, $hash);
    }

    /**
     * 新增用户
     * @param array $data
     * @return int
     */
    #[Transaction]
    public function save(array $data): int
    {
        $role_ids = $data['role_ids'] ?? [];
        $post_ids = $data['post_ids'] ?? [];
        $dept_ids = $data['dept_ids'] ?? [];
        $this->filterExecuteAttributes($data, true);

        $user = $this->model::create($data);
        $user->roles()->sync($role_ids, false);
        $user->posts()->sync($post_ids, false);
        $user->depts()->sync($dept_ids, false);
        return $user->id;
    }

    /**
     * 更新用户
     * @param int $id
     * @param array $data
     * @return bool
     */
    #[Transaction]
    public function update(int $id, array $data): bool
    {
        $role_ids = $data['role_ids'] ?? [];
        $post_ids = $data['post_ids'] ?? [];
        $dept_ids = $data['dept_ids'] ?? [];
        $this->filterExecuteAttributes($data, true);

        $result = parent::update($id, $data);
        $user = $this->model::find($id);
        if ($user && $result) {
            !empty($role_ids) && $user->roles()->sync($role_ids);
            !empty($dept_ids) && $user->depts()->sync($dept_ids);
            $user->posts()->sync($post_ids);
            return true;
        }
        return false;
    }

    /**
     * 真实批量删除用户
     * @param array $ids
     * @return bool
     */
    #[Transaction]
    public function realDelete(array $ids): bool
    {
        foreach ($ids as $id) {
            $user = $this->model::withTrashed()->find($id);
            if ($user) {
                $user->roles()->detach();
                $user->posts()->detach();
                $user->depts()->detach();
                $user->forceDelete();
            }
        }
        return true;
    }

    /**
     * 获取用户信息
     * @param int $id
     * @param array $column
     * @return PaModel|null
     */
    public function read(int $id, array $column = ['*']): ?PaModel
    {
        $user = $this->model::find($id);
        if ($user) {
            $user->setAttribute('roleList', $user->roles()->get(['id', 'name']) ?: []);
            $user->setAttribute('postList', $user->posts()->get(['id', 'name']) ?: []);
            $user->setAttribute('deptList', $user->depts()->get(['id', 'name']) ?: []);
        }
        return $user;
    }

    /**
     * 搜索处理器
     * @param Builder $query
     * @param array $params
     * @return Builder
     */
    public function handleSearch(Builder $query, array $params): Builder
    {
        if (!empty($params['dept_id']) && is_string($params['dept_id'])) {
            $tablePrefix = env('DB_PREFIX');
            $query->selectRaw(Db::raw("DISTINCT {$tablePrefix}user.*"))
                ->join('user_dept as dept', 'user.id', '=', 'dept.user_id')
                ->whereIn('dept.dept_id', Dept::query()
                    ->where(function ($query) use ($params) {
                        $query->where('id', '=', $params['dept_id'])
                            ->orWhere('level', 'like', $params['dept_id'] . ',%')
                            ->orWhere('level', 'like', '%,' . $params['dept_id'])
                            ->orWhere('level', 'like', '%,' . $params['dept_id'] . ',%');
                    })
                    ->pluck('id')
                    ->toArray()
                );
        }
        if (!empty($params['username'])) {
            $query->where('username', 'like', '%'.$params['username'].'%');
        }
        if (!empty($params['nickname'])) {
            $query->where('nickname', 'like', '%'.$params['nickname'].'%');
        }
        if (!empty($params['phone'])) {
            $query->where('phone', '=', $params['phone']);
        }
        if (!empty($params['email'])) {
            $query->where('email', '=', $params['email']);
        }
        if (!empty($params['status'])) {
            $query->where('status', $params['status']);
        }

        if (!empty($params['filterSuperAdmin'])) {
            $query->whereNotIn('id', [env('SUPER_ADMIN')]);
        }

        if (!empty($params['created_at']) && is_array($params['created_at']) && count($params['created_at']) == 2) {
            $query->whereBetween(
                'created_at',
                [ $params['created_at'][0] . ' 00:00:00', $params['created_at'][1] . ' 23:59:59' ]
            );
        }

        if (!empty($params['userIds'])) {
            $query->whereIn('id', $params['userIds']);
        }

        if (!empty($params['showDept'])) {
            $isAll = $params['showDeptAll'] ?? false;

            $query->with(['depts' => function($query) use($isAll){
                /* @var Builder $query*/
                $query->where('status', Dept::ENABLE);
                return $isAll ? $query->select(['*']) : $query->select(['id', 'name']);
            }]);
        }

        if (!empty($params['role_id'])) {
            $tablePrefix = env('DB_PREFIX');
            $query->whereRaw(
                "id IN ( SELECT user_id FROM {$tablePrefix}user_role WHERE role_id = ? )",
                [ $params['role_id'] ]
            );
        }

        if (!empty($params['post_id'])) {
            $tablePrefix = env('DB_PREFIX');
            $query->whereRaw(
                "id IN ( SELECT user_id FROM {$tablePrefix}user_post WHERE post_id = ? )",
                [ $params['post_id'] ]
            );
        }

        return $query;
    }

    /**
     * 初始化用户密码
     * @param int $id
     * @param string $password
     * @return bool
     */
    public function initUserPassword(int $id, string $password): bool
    {
        $model = $this->model::find($id);
        if ($model) {
            $model->password = $password;
            return $model->save();
        }
        return false;
    }

    /**
     * 根据用户ID列表获取用户基础信息
     */
    public function getUserInfoByIds(array $ids, ?array $select = null): array
    {
        if (! $select) $select = ['id', 'username', 'nickname', 'phone', 'email', 'created_at'];
        return $this->model::query()->whereIn('id', $ids)->select($select)->get()->toArray();
    }
}