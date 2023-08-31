<?php

declare(strict_types=1);

use Hyperf\Database\Seeders\Seeder;
use Hyperf\DbConnection\Db;

class CrontabSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Db::table('crontab')->truncate();
        foreach ($this->getData() as $item) {
            Db::insert($item);
        }
    }

    public function getData(): array
    {
        $tableName = env('DB_PREFIX') . \App\Backend\Model\Crontab::getModel()->getTable();
        return [
            "INSERT INTO `{$tableName}` VALUES (1, 'urlCrontab', '3', 'http://127.0.0.1:9501/', '', '59 */1 * * * *', 2, 2, NULL, NULL, '2021-08-07 23:28:28', '2021-08-07 23:44:55', '请求127.0.0.1')",
            "INSERT INTO `{$tableName}` VALUES (2, '每月1号清理所有日志', '2', 'App\System\Crontab\ClearLogCrontab', '', '0 0 0 1 * *', 2, 2, NULL, NULL, '2022-04-11 11:15:48', '2022-04-11 11:15:48', '')"
        ];
    }
}
