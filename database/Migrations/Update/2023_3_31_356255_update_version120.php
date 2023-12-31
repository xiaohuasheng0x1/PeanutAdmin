<?php

use Hyperf\Database\Migrations\Migration;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Schema\Schema;
use Hyperf\DbConnection\Db;

/**
 * 升级1.2.0版
 */
class UpdateVersion120 extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('datasource')) {
            Schema::create('datasource', function (Blueprint $table) {
                $table->engine = 'Innodb';
                $table->comment('数据源表');
                $table->bigIncrements('id')->comment('主键');
                $table->addColumn('string', 'source_name', ['length' => 32, 'comment' => '数据源名称']);
                $table->addColumn('string', 'dsn', ['length' => 255, 'comment' => '连接dsn字符串'])->nullable();
                $table->addColumn('string', 'username', ['length' => 64, 'comment' => '数据库名称'])->nullable();
                $table->addColumn('string', 'password', ['length' => 32, 'comment' => '数据库用户'])->nullable();
                $table->addColumn('bigInteger', 'created_by', ['comment' => '创建者'])->nullable();
                $table->addColumn('bigInteger', 'updated_by', ['comment' => '更新者'])->nullable();
                $table->addColumn('timestamp', 'created_at', ['precision' => 0, 'comment' => '创建时间'])->nullable();
                $table->addColumn('timestamp', 'updated_at', ['precision' => 0, 'comment' => '更新时间'])->nullable();
                $table->addColumn('string', 'remark', ['length' => 255, 'comment' => '备注'])->nullable();
            });
        }
        // 菜单数据
        $pid = Db::table('menu')->insertGetId(
            [
                'parent_id' => 4000,
                'level' => '0,4000',
                'name' => '数据源管理',
                'code' => 'datasource',
                'icon' => 'icon-storage',
                'route' => 'backend/datasource',
                'component' => 'backend/datasource/index',
                'redirect' => NULL,
                'is_hidden' => '2',
                'type' => 'M',
                'status' => '1',
                'sort' => 0,
                'created_by' => 1,
                'updated_by' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'deleted_at' => NULL,
                'remark' => NULL,
            ]
        );

        $tableName = env('DB_PREFIX') . \App\Backend\Model\Menu::getModel()->getTable();

        $sql = [
            "INSERT INTO `{$tableName}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES ({$pid}, '0,4000,{$pid}', '数据源管理列表', 'datasource:index', NULL, NULL, NULL, NULL, 2, 'B', 1, 0, 1, NULL, '2023-04-01 20:20:01', '2023-04-01 20:20:01', NULL, NULL)",
            "INSERT INTO `{$tableName}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES ({$pid}, '0,4000,{$pid}', '数据源管理保存', 'datasource:save', NULL, NULL, NULL, NULL, 2, 'B', 1, 0, 1, NULL, '2023-04-01 20:20:01', '2023-04-01 20:20:01', NULL, NULL)",
            "INSERT INTO `{$tableName}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES ({$pid}, '0,4000,{$pid}', '数据源管理更新', 'datasource:update', NULL, NULL, NULL, NULL, 2, 'B', 1, 0, 1, NULL, '2023-04-01 20:20:01', '2023-04-01 20:20:01', NULL, NULL)",
            "INSERT INTO `{$tableName}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES ({$pid}, '0,4000,{$pid}', '数据源管理读取', 'datasource:read', NULL, NULL, NULL, NULL, 2, 'B', 1, 0, 1, NULL, '2023-04-01 20:20:01', '2023-04-01 20:20:01', NULL, NULL)",
            "INSERT INTO `{$tableName}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES ({$pid}, '0,4000,{$pid}', '数据源管理删除', 'datasource:delete', NULL, NULL, NULL, NULL, 2, 'B', 1, 0, 1, NULL, '2023-04-01 20:20:01', '2023-04-01 20:20:01', NULL, NULL)",
            "INSERT INTO `{$tableName}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES ({$pid}, '0,4000,{$pid}', '数据源管理导入', 'datasource:import', NULL, NULL, NULL, NULL, 2, 'B', 1, 0, 1, NULL, '2023-04-01 20:20:01', '2023-04-01 20:20:01', NULL, NULL)",
            "INSERT INTO `{$tableName}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES ({$pid}, '0,4000,{$pid}', '数据源管理导出', 'datasource:export', NULL, NULL, NULL, NULL, 2, 'B', 1, 0, 1, NULL, '2023-04-01 20:20:01', '2023-04-01 20:20:01', NULL, NULL)",
        ];

        foreach ($sql as $item) {
            Db::insert($item);
        }

        redis()->flushAll();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datasource');
    }
}
