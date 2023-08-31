<?php

declare(strict_types=1);

use Hyperf\Database\Seeders\Seeder;
use Hyperf\DbConnection\Db;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Db::table('menu')->truncate();
        foreach ($this->getData() as $item) {
            Db::insert($item);
        }
    }

    protected function getData(): array
    {
        $model = env('DB_PREFIX') . \App\Backend\Model\Menu::getModel()->getTable();
        return [
            "INSERT INTO `{$model}` VALUES (1000, 0, '0', '权限', 'permission', 'pa-icon-permission', 'permission', '', NULL, '2', 'M', 1, 99, NULL, NULL, '2021-07-25 18:48:47', '2021-07-25 18:48:47', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1100, 1000, '0,1000', '用户管理', 'user', 'pa-icon-user', 'user', 'backend/user/index', NULL, '2', 'M', 1, 99, NULL, NULL, '2021-07-25 18:50:15', '2021-07-25 18:50:15', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1101, 1100, '0,1000,1100', '用户列表', 'user:index', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-25 18:50:15', '2021-07-25 18:50:15', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1102, 1100, '0,1000,1100', '用户回收站列表', 'user:recycle', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-25 18:50:15', '2021-07-25 18:50:15', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1103, 1100, '0,1000,1100', '用户保存', 'user:save', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-25 18:50:15', '2021-07-25 18:50:15', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1104, 1100, '0,1000,1100', '用户更新', 'user:update', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-25 18:50:15', '2021-07-25 18:50:15', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1105, 1100, '0,1000,1100', '用户删除', 'user:delete', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-25 18:50:15', '2021-07-25 18:50:15', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1106, 1100, '0,1000,1100', '用户读取', 'user:read', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-25 18:50:15', '2021-07-25 18:50:15', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1107, 1100, '0,1000,1100', '用户恢复', 'user:recovery', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-25 18:50:15', '2021-07-25 18:50:15', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1108, 1100, '0,1000,1100', '用户真实删除', 'user:realDelete', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-25 18:50:15', '2021-07-25 18:50:15', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1109, 1100, '0,1000,1100', '用户导入', 'user:import', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-25 18:50:15', '2021-07-25 18:50:15', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1110, 1100, '0,1000,1100', '用户导出', 'user:export', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-25 18:50:15', '2021-07-25 18:50:15', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1111, 1100, '0,1000,1100', '用户状态改变', 'user:changeStatus', '', NULL, '', NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-25 18:53:02', '2021-07-25 18:53:02', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1112, 1100, '0,1000,1100', '用户初始化密码', 'user:initUserPassword', '', NULL, '', NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-25 18:55:55', '2021-07-25 18:55:55', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1113, 1100, '0,1000,1100', '更新用户缓存', 'user:cache', '', NULL, '', NULL, '1', 'B', 1, 0, NULL, NULL, '2021-08-08 18:30:57', '2021-08-08 18:30:57', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1114, 1100, '0,1000,1100', '设置用户首页', 'user:homePage', '', NULL, '', NULL, '1', 'B', 1, 0, NULL, NULL, '2021-08-08 18:34:30', '2021-08-08 18:34:30', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1200, 1000, '0,1000', '菜单管理', 'menus', 'icon-menu', 'menu', 'backend/menu/index', NULL, '2', 'M', 1, 96, NULL, NULL, '2021-07-25 19:01:47', '2021-07-25 19:01:47', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1201, 1200, '0,1000,1200', '菜单列表', 'menus:index', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-25 19:01:47', '2021-07-25 19:01:47', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1202, 1200, '0,1000,1200', '菜单回收站', 'menus:recycle', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-25 19:01:47', '2021-07-25 19:01:47', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1203, 1200, '0,1000,1200', '菜单保存', 'menus:save', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-25 19:01:47', '2021-07-25 19:01:47', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1204, 1200, '0,1000,1200', '菜单更新', 'menus:update', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-25 19:01:47', '2021-07-25 19:01:47', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1205, 1200, '0,1000,1200', '菜单删除', 'menus:delete', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-25 19:01:47', '2021-07-25 19:01:47', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1206, 1200, '0,1000,1200', '菜单读取', 'menus:read', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-25 19:01:47', '2021-07-25 19:01:47', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1207, 1200, '0,1000,1200', '菜单恢复', 'menus:recovery', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-25 19:01:47', '2021-07-25 19:01:47', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1208, 1200, '0,1000,1200', '菜单真实删除', 'menus:realDelete', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-25 19:01:47', '2021-07-25 19:01:47', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1209, 1200, '0,1000,1200', '菜单导入', 'menus:import', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-25 19:01:47', '2021-07-25 19:01:47', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1210, 1200, '0,1000,1200', '菜单导出', 'menus:export', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-25 19:01:47', '2021-07-25 19:01:47', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1300, 1000, '0,1000', '部门管理', 'dept', 'pa-icon-dept', 'dept', 'backend/dept/index', NULL, '2', 'M', 1, 97, NULL, NULL, '2021-07-25 19:16:33', '2021-07-25 19:16:33', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1301, 1300, '0,1000,1300', '部门列表', 'dept:index', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-25 19:16:33', '2021-07-25 19:16:33', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1302, 1300, '0,1000,1300', '部门回收站', 'dept:recycle', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-25 19:16:33', '2021-07-25 19:16:33', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1303, 1300, '0,1000,1300', '部门保存', 'dept:save', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-25 19:16:33', '2021-07-25 19:16:33', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1304, 1300, '0,1000,1300', '部门更新', 'dept:update', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-25 19:16:33', '2021-07-25 19:16:33', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1305, 1300, '0,1000,1300', '部门删除', 'dept:delete', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-25 19:16:33', '2021-07-25 19:16:33', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1306, 1300, '0,1000,1300', '部门读取', 'dept:read', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-25 19:16:33', '2021-07-25 19:16:33', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1307, 1300, '0,1000,1300', '部门恢复', 'dept:recovery', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-25 19:16:33', '2021-07-25 19:16:33', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1308, 1300, '0,1000,1300', '部门真实删除', 'dept:realDelete', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-25 19:16:33', '2021-07-25 19:16:33', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1309, 1300, '0,1000,1300', '部门导入', 'dept:import', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-25 19:16:33', '2021-07-25 19:16:33', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1310, 1300, '0,1000,1300', '部门导出', 'dept:export', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-25 19:16:33', '2021-07-25 19:16:33', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1400, 1000, '0,1000', '角色管理', 'role', 'pa-icon-role', 'role', 'backend/role/index', NULL, '2', 'M', 1, 98, NULL, NULL, '2021-07-25 19:17:37', '2021-07-25 19:17:37', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1401, 1400, '0,1000,1400', '角色列表', 'role:index', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-25 19:17:37', '2021-07-25 19:17:37', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1402, 1400, '0,1000,1400', '角色回收站', 'role:recycle', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-25 19:17:38', '2021-07-25 19:17:38', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1403, 1400, '0,1000,1400', '角色保存', 'role:save', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-25 19:17:38', '2021-07-25 19:17:38', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1404, 1400, '0,1000,1400', '角色更新', 'role:update', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-25 19:17:38', '2021-07-25 19:17:38', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1405, 1400, '0,1000,1400', '角色删除', 'role:delete', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-25 19:17:38', '2021-07-25 19:17:38', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1406, 1400, '0,1000,1400', '角色读取', 'role:read', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-25 19:17:38', '2021-07-25 19:17:38', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1407, 1400, '0,1000,1400', '角色恢复', 'role:recovery', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-25 19:17:38', '2021-07-25 19:17:38', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1408, 1400, '0,1000,1400', '角色真实删除', 'role:realDelete', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-25 19:17:38', '2021-07-25 19:17:38', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1409, 1400, '0,1000,1400', '角色导入', 'role:import', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-25 19:17:38', '2021-07-25 19:17:38', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1410, 1400, '0,1000,1400', '角色导出', 'role:export', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-25 19:17:38', '2021-07-25 19:17:38', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1411, 1400, '0,1000,1400', '角色状态改变', 'role:changeStatus', '', NULL, '', NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-30 11:21:24', '2021-07-30 11:21:24', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1412, 1400, '0,1000,1400', '更新菜单权限', 'role:menuPermission', '', NULL, '', NULL, '1', 'B', 1, 0, NULL, NULL, '2021-08-09 11:52:33', '2021-08-09 11:52:33', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1413, 1400, '0,1000,1400', '更新数据权限', 'role:dataPermission', '', NULL, '', NULL, '1', 'B', 1, 0, NULL, NULL, '2021-08-09 11:52:52', '2021-08-09 11:52:52', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1500, 1000, '0,1000', '岗位管理', 'post', 'pa-icon-post', 'post', 'backend/post/index', NULL, '2', 'M', 1, 0, NULL, NULL, '2021-07-25 20:46:38', '2021-07-25 20:46:38', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1501, 1500, '0,1000,1500', '岗位列表', 'post:index', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-25 20:46:38', '2021-07-25 20:46:38', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1502, 1500, '0,1000,1500', '岗位回收站', 'post:recycle', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-25 20:46:38', '2021-07-25 20:46:38', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1503, 1500, '0,1000,1500', '岗位保存', 'post:save', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-25 20:46:38', '2021-07-25 20:46:38', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1504, 1500, '0,1000,1500', '岗位更新', 'post:update', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-25 20:46:38', '2021-07-25 20:46:38', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1505, 1500, '0,1000,1500', '岗位删除', 'post:delete', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-25 20:46:38', '2021-07-25 20:46:38', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1506, 1500, '0,1000,1500', '岗位读取', 'post:read', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-25 20:46:38', '2021-07-25 20:46:38', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1507, 1500, '0,1000,1500', '岗位恢复', 'post:recovery', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-25 20:46:38', '2021-07-25 20:46:38', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1508, 1500, '0,1000,1500', '岗位真实删除', 'post:realDelete', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-25 20:46:38', '2021-07-25 20:46:38', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1509, 1500, '0,1000,1500', '岗位导入', 'post:import', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-25 20:46:38', '2021-07-25 20:46:38', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1510, 1500, '0,1000,1500', '岗位导出', 'post:export', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-25 20:46:38', '2021-07-25 20:46:38', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2000, 0, '0', '数据', 'dataCenter', 'icon-storage', 'dataCenter', '', NULL, '2', 'M', 1, 98, NULL, NULL, '2021-07-31 17:17:03', '2021-07-31 17:17:03', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2100, 2000, '0,2000', '数据字典', 'dict', 'pa-icon-dict', 'dict', 'backend/dict/index', NULL, '2', 'M', 1, 99, NULL, NULL, '2021-07-31 18:33:45', '2021-07-31 18:33:45', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2101, 2100, '0,2000,2100', '数据字典列表', 'dict:index', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-31 18:33:45', '2021-07-31 18:33:45', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2102, 2100, '0,2000,2100', '数据字典回收站', 'dict:recycle', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-31 18:33:45', '2021-07-31 18:33:45', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2103, 2100, '0,2000,2100', '数据字典保存', 'dict:save', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-31 18:33:45', '2021-07-31 18:33:45', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2104, 2100, '0,2000,2100', '数据字典更新', 'dict:update', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-31 18:33:45', '2021-07-31 18:33:45', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2105, 2100, '0,2000,2100', '数据字典删除', 'dict:delete', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-31 18:33:45', '2021-07-31 18:33:45', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2106, 2100, '0,2000,2100', '数据字典读取', 'dict:read', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-31 18:33:46', '2021-07-31 18:33:46', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2107, 2100, '0,2000,2100', '数据字典恢复', 'dict:recovery', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-31 18:33:46', '2021-07-31 18:33:46', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2108, 2100, '0,2000,2100', '数据字典真实删除', 'dict:realDelete', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-31 18:33:46', '2021-07-31 18:33:46', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2109, 2100, '0,2000,2100', '数据字典导入', 'dict:import', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-31 18:33:46', '2021-07-31 18:33:46', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2110, 2100, '0,2000,2100', '数据字典导出', 'dict:export', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-31 18:33:46', '2021-07-31 18:33:46', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2200, 2000, '0,2000', '附件管理', 'attachment', 'pa-icon-attach', 'attachment', 'backend/attachment/index', NULL, '2', 'M', 1, 98, NULL, NULL, '2021-07-31 18:36:34', '2021-07-31 18:36:34', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2201, 2300, '0,2000,2200', '附件删除', 'attachment:delete', '', NULL, '', NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-31 18:37:20', '2021-07-31 18:37:20', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2202, 2200, '0,2000,2200', '附件列表', 'attachment:index', '', NULL, '', NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-31 18:38:05', '2021-07-31 18:38:05', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2203, 2200, '0,2000,2200', '附件回收站', 'attachment:recycle', '', NULL, '', NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-31 18:38:57', '2021-07-31 18:38:57', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2204, 2200, '0,2000,2200', '附件真实删除', 'attachment:realDelete', '', NULL, '', NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-31 18:40:44', '2021-07-31 18:40:44', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2300, 2000, '0,2000', '登录日志', 'loginLog', 'icon-idcard', 'loginLog', 'backend/logs/loginLog', NULL, '2', 'M', 1, 0, NULL, NULL, '2021-07-31 18:54:55', '2021-07-31 18:54:55', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2301, 2100, '0,2000,2300', '登录日志删除', 'loginLog:delete', '', NULL, '', NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-31 18:56:43', '2021-07-31 18:56:43', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2400, 2000, '0,2000', '操作日志', 'operLog', 'icon-robot', 'operLog', 'backend/logs/operLog', NULL, '2', 'M', 1, 0, NULL, NULL, '2021-07-31 18:55:40', '2021-07-31 18:55:40', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2401, 2200, '0,2000,2400', '操作日志删除', 'operLog:delete', '', NULL, '', NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-31 18:56:19', '2021-07-31 18:56:19', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2500, 2000, '0,2000', '队列日志', 'queueLog', 'icon-layers', 'queueLog', 'backend/logs/queueLog', NULL, '2', 'M', 1, 0, NULL, NULL, '2021-12-25 16:41:14', '2021-12-25 16:41:14', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2501, 2300, '0,2000,2500', '删除队列日志', 'queueLog:delete', '', NULL, '', NULL, '1', 'B', 1, 0, NULL, NULL, '2021-12-25 16:42:42', '2021-12-25 16:42:42', NULL, NULL)",

            "INSERT INTO `{$model}` VALUES (4000, 0, '0', '工具', 'devTools', 'pa-icon-tool', 'devTools', '', NULL, '2', 'M', 1, 95, NULL, NULL, '2021-07-31 19:03:32', '2021-07-31 19:03:32', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (4200, 4000, '0,4000', '代码生成器', 'codes', 'pa-icon-code', 'code', 'backend/code/index', NULL, '2', 'M', 1, 98, NULL, NULL, '2021-07-31 19:36:17', '2021-07-31 19:36:17', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (4201, 4200, '0,4000,4200', '预览代码', 'codes:preview', '', NULL, '', NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-31 19:36:44', '2021-07-31 19:36:44', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (4202, 4200, '0,4000,4200', '装载数据表', 'codes:loadTable', '', NULL, '', NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-31 19:38:03', '2021-07-31 19:38:03', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (4203, 4200, '0,4000,4200', '删除业务表', 'codes:delete', '', NULL, '', NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-31 19:38:53', '2021-07-31 19:38:53', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (4204, 4200, '0,4000,4200', '同步业务表', 'codes:sync', '', NULL, '', NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-31 19:39:18', '2021-07-31 19:39:18', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (4205, 4200, '0,4000,4200', '生成代码', 'codes:generate', '', NULL, '', NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-31 19:39:48', '2021-07-31 19:39:48', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (4400, 4000, '0,4000', '定时任务', 'crontab', 'icon-schedule', 'crontab', 'backend/crontab/index', '', '2', 'M', 1, 0, NULL, NULL, '2021-07-31 19:47:49', '2021-07-31 19:47:49', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (4401, 4400, '0,4000,4400', '定时任务列表', 'crontab:index', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-31 19:47:49', '2021-07-31 19:47:49', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (4402, 4400, '0,4000,4400', '定时任务保存', 'crontab:save', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-31 19:47:49', '2021-07-31 19:47:49', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (4403, 4400, '0,4000,4400', '定时任务更新', 'crontab:update', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-31 19:47:49', '2021-07-31 19:47:49', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (4404, 4400, '0,4000,4400', '定时任务删除', 'crontab:delete', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-31 19:47:49', '2021-07-31 19:47:49', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (4405, 4400, '0,4000,4400', '定时任务读取', 'crontab:read', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-31 19:47:49', '2021-07-31 19:47:49', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (4406, 4400, '0,4000,4400', '定时任务导入', 'crontab:import', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-31 19:47:49', '2021-07-31 19:47:49', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (4407, 4400, '0,4000,4400', '定时任务导出', 'crontab:export', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-07-31 19:47:49', '2021-07-31 19:47:49', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (4408, 4400, '0,4000,4400', '定时任务执行', 'crontab:run', '', NULL, '', NULL, '1', 'B', 1, 0, NULL, NULL, '2021-08-07 23:44:06', '2021-08-07 23:44:06', NULL, NULL)",

            "INSERT INTO `{$model}` VALUES (4500, 0, '0', '系统设置', 'config', 'icon-settings', 'system', 'backend/config/index', '', '2', 'M', 1, 0, NULL, NULL, '2021-07-31 19:58:57', '2021-07-31 19:58:57', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (4502, 4500, '0,4500', '配置列表', 'config:index', '', NULL, '', NULL, '1', 'B', 1, 0, NULL, NULL, '2021-08-10 13:09:18', '2021-08-10 13:09:18', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (4504, 4500, '0,4500', '新增配置 ', 'config:save', '', NULL, '', NULL, '1', 'B', 1, 0, NULL, NULL, '2021-08-10 13:11:56', '2021-08-10 13:11:56', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (4505, 4500, '0,4500', '更新配置', 'config:update', '', NULL, '', NULL, '1', 'B', 1, 0, NULL, NULL, '2021-08-10 13:12:25', '2021-08-10 13:12:25', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (4506, 4500, '0,4500', '删除配置', 'config:delete', '', NULL, '', NULL, '1', 'B', 1, 0, NULL, NULL, '2021-08-10 13:13:33', '2021-08-10 13:13:33', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (4507, 4500, '0,4500', '清除配置缓存', 'config:clearCache', '', NULL, '', NULL, '1', 'B', 1, 0, NULL, NULL, '2021-08-10 13:13:59', '2021-08-10 13:13:59', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (4409, 4400, '0,4000,4400', '定时任务日志删除', 'crontab:deleteLog', '', NULL, '', NULL, '1', 'B', 1, 0, NULL, NULL, '2021-12-06 22:06:12', '2021-12-06 22:06:12', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1311, 1300, '0,1000,1300', '部门状态改变', 'dept:changeStatus', '', NULL, '', NULL, '1', 'B', 1, 0, NULL, NULL, '2021-11-09 18:26:15', '2021-11-09 18:26:15', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (1511, 1500, '0,1000,1500', '岗位状态改变', 'post:changeStatus', '', NULL, '', NULL, '1', 'B', 1, 0, NULL, NULL, '2021-11-09 18:26:15', '2021-11-09 18:26:15', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2112, 2100, '0,2000,2100', '字典状态改变', 'dataDict:changeStatus', '', NULL, '', NULL, '1', 'B', 1, 0, NULL, NULL, '2021-11-09 18:26:15', '2021-11-09 18:26:15', NULL, NULL)",

            "INSERT INTO `{$model}` VALUES (2700, 2000, '0,2000', '系统公告', 'notice', 'icon-bulb', 'notice', 'backend/notice/index', NULL, '2', 'M', 1, 94, NULL, NULL, '2021-12-25 18:10:20', '2021-12-25 18:10:20', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2701, 2700, '0,2000,2700', '系统公告列表', 'notice:index', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-12-25 18:10:20', '2021-12-25 18:10:20', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2702, 2700, '0,2000,2700', '系统公告回收站', 'notice:recycle', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-12-25 18:10:20', '2021-12-25 18:10:20', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2703, 2700, '0,2000,2700', '系统公告保存', 'notice:save', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-12-25 18:10:20', '2021-12-25 18:10:20', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2704, 2700, '0,2000,2700', '系统公告更新', 'notice:update', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-12-25 18:10:20', '2021-12-25 18:10:20', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2705, 2700, '0,2000,2700', '系统公告删除', 'notice:delete', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-12-25 18:10:20', '2021-12-25 18:10:20', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2706, 2700, '0,2000,2700', '系统公告读取', 'notice:read', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-12-25 18:10:20', '2021-12-25 18:10:20', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2707, 2700, '0,2000,2700', '系统公告恢复', 'notice:recovery', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-12-25 18:10:20', '2021-12-25 18:10:20', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2708, 2700, '0,2000,2700', '系统公告真实删除', 'notice:realDelete', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-12-25 18:10:20', '2021-12-25 18:10:20', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2709, 2700, '0,2000,2700', '系统公告导入', 'notice:import', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-12-25 18:10:20', '2021-12-25 18:10:20', NULL, NULL)",
            "INSERT INTO `{$model}` VALUES (2710, 2700, '0,2000,2700', '系统公告导出', 'notice:export', NULL, NULL, NULL, NULL, '1', 'B', 1, 0, NULL, NULL, '2021-12-25 18:10:20', '2021-12-25 18:10:20', NULL, NULL)",
        ];
    }
}
