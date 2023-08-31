<?php


declare(strict_types=1);

namespace App\Common\Traits;

use App\Backend\Model\Dept;
use App\Backend\Model\Role;
use App\Backend\Model\User;
use App\Common\Exception\PaException;
use Hyperf\Database\Model\Builder;
use Hyperf\DbConnection\Db;

trait ModelMacroTrait
{
    /**
     * 注册自定义方法
     */
    private function registerUserDataScope()
    {
        // 数据权限方法
        $model = $this;
        Builder::macro('userDataScope', function(?int $userid = null) use($model)
        {
            if (! config('peanutadmin.data_scope_enabled')) {
                return $this;
            }

            $userid = is_null($userid) ? (int) user()->getId() : $userid;

            if (empty($userid)) {
                throw new PaException('Data Scope missing user_id');
            }

            /* @var Builder $this */
            if ($userid == env('SUPER_ADMIN')) {
                return $this;
            }

            if (!in_array($model->getDataScopeField(), $model->getFillable())) {
                return $this;
            }

            $dataScope = new class($userid, $this, $model)
            {
                // 用户ID
                protected int $userid;

                // 查询构造器
                protected Builder $builder;

                // 数据范围用户ID列表
                protected array $userIds = [];

                // 外部模型
                protected mixed $model;

                public function __construct(int $userid, Builder $builder, mixed $model)
                {
                    $this->userid  = $userid;
                    $this->builder = $builder;
                    $this->model = $model;
                }

                /**
                 * @return Builder
                 */
                public function execute(): Builder
                {
                    $this->getUserDataScope();
                    return empty($this->userIds)
                        ? $this->builder
                        : $this->builder->whereIn($this->model->getDataScopeField(), array_unique($this->userIds));
                }

                protected function getUserDataScope(): void
                {
                    $userModel = User::find($this->userid, ['id']);
                    $roles = $userModel->roles()->get(['id', 'data_scope']);

                    foreach ($roles as $role) {
                        switch ($role->data_scope) {
                            case Role::ALL_SCOPE:
                                // 如果是所有权限，跳出所有循环
                                break 2;
                            case Role::CUSTOM_SCOPE:
                                // 自定义数据权限
                                $deptIds = $role->depts()->pluck('id')->toArray();
                                $this->userIds = array_merge(
                                    $this->userIds,
                                    Db::table('user_dept')->whereIn('dept_id', $deptIds)->pluck('user_id')->toArray()
                                );
                                $this->userIds[] = $this->userid;
                                break;
                            case Role::SELF_DEPT_SCOPE:
                                // 本部门数据权限
                                $deptIds = Db::table('user_dept')->where('user_id', $userModel->id)->pluck('dept_id')->toArray();
                                $this->userIds = array_merge(
                                    $this->userIds,
                                    Db::table('user_dept')->whereIn('dept_id', $deptIds)->pluck('user_id')->toArray()
                                );
                                $this->userIds[] = $this->userid;
                                break;
                            case Role::DEPT_BELOW_SCOPE:
                                // 本部门及子部门数据权限
                                $parentDepts = Db::table('user_dept')->where('user_id', $userModel->id)->pluck('dept_id')->toArray();
                                $ids = [];
                                foreach ($parentDepts as $deptId) {
                                    $ids[] = Dept::query()
                                        ->where(function ($query) use ($deptId) {
                                            $query->where('id', '=', $deptId)
                                                ->orWhere('level', 'like', $deptId . ',%')
                                                ->orWhere('level', 'like', '%,' . $deptId)
                                                ->orWhere('level', 'like', '%,' . $deptId . ',%');
                                        })
                                        ->pluck('id')
                                        ->toArray();
                                }
                                $deptIds = array_merge($parentDepts, ...$ids);
                                $this->userIds = array_merge(
                                    $this->userIds,
                                    Db::table('user_dept')->whereIn('dept_id', $deptIds)->pluck('user_id')->toArray()
                                );
                                $this->userIds[] = $this->userid;
                                break;
                            case Role::SELF_SCOPE:
                                $this->userIds[] = $this->userid;
                                break;
                            default:
                                break;
                        }
                    }
                }
            };

            return $dataScope->execute();
        });
    }

    /**
     * Description:注册常用自定义方法
     * User:mike
     */
    private function registerBase()
    {
        //添加andFilterWhere()方法
        Builder::macro('andFilterWhere', function ($key, $operator, $value = NULL) {
            if ($value === '' || $value === '%%' || $value === '%') {
                return $this;
            }
            if ($operator === '' || $operator === '%%' || $operator === '%') {
                return $this;
            }
            if($value === NULL){
                return $this->where($key, $operator);
            }else{
                return $this->where($key, $operator, $value);
            }
        });

        //添加orFilterWhere()方法
        Builder::macro('orFilterWhere', function ($key, $operator, $value = NULL) {
            if ($value === '' || $value === '%%' || $value === '%') {
                return $this;
            }
            if ($operator === '' || $operator === '%%' || $operator === '%') {
                return $this;
            }
            if($value === NULL){
                return $this->orWhere($key, $operator);
            }else{
                return $this->orWhere($key, $operator, $value);
            }
        });
    }
}
