<?php

declare(strict_types=1);


use Hyperf\Database\Seeders\Seeder;
use Hyperf\DbConnection\Db;

class DeptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function run()
    {
        Db::table('dept')->truncate();
        Db::table('dept')->insert(
            [
                'parent_id' => 0,
                'level' => '0',
                'name' => '总部门',
                'phone' => '16888888888',
                'created_by' => env('SUPER_ADMIN', 1),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        );
    }
}
