<?php

declare(strict_types=1);

use Hyperf\Database\Seeders\Seeder;
use Hyperf\DbConnection\Db;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Db::table('config')->truncate();
        $tableName = env('DB_PREFIX') . \App\Backend\Model\Config::getModel()->getTable();
        $sql = [
            "INSERT INTO `{$tableName}`(`group_id`, `key`, `value`, `name`, `input_type`, `config_select_data`, `sort`, `remark`) VALUES (1, 'site_copyright', NULL, '版权信息', 'textarea', NULL, 96, NULL)",
            "INSERT INTO `{$tableName}`(`group_id`, `key`, `value`, `name`, `input_type`, `config_select_data`, `sort`, `remark`) VALUES (1, 'site_desc', NULL, '网站描述', 'textarea', NULL, 97, NULL)",
            "INSERT INTO `{$tableName}`(`group_id`, `key`, `value`, `name`, `input_type`, `config_select_data`, `sort`, `remark`) VALUES (1, 'site_keywords', '后台管理系统', '网站关键字', 'input', NULL, 98, NULL)",
            "INSERT INTO `{$tableName}`(`group_id`, `key`, `value`, `name`, `input_type`, `config_select_data`, `sort`, `remark`) VALUES (1, 'site_name', 'PeanutAdmin', '网站名称', 'input', NULL, 99, NULL)",
            "INSERT INTO `{$tableName}`(`group_id`, `key`, `value`, `name`, `input_type`, `config_select_data`, `sort`, `remark`) VALUES (1, 'site_record_number', NULL, '网站备案号', 'input', NULL, 95, NULL)",
            "INSERT INTO `{$tableName}`(`group_id`, `key`, `value`, `name`, `input_type`, `config_select_data`, `sort`, `remark`) VALUES (2, 'upload_allow_file', 'txt,doc,docx,xls,xlsx,ppt,pptx,rar,zip,7z,gz,pdf,wps,md', '文件类型', 'input', NULL, 0, NULL)",
            "INSERT INTO `{$tableName}`(`group_id`, `key`, `value`, `name`, `input_type`, `config_select_data`, `sort`, `remark`) VALUES (2, 'upload_allow_image', 'jpg,jpeg,png,gif,svg,bmp', '图片类型', 'input', NULL, 0, NULL)",
            "INSERT INTO `{$tableName}`(`group_id`, `key`, `value`, `name`, `input_type`, `config_select_data`, `sort`, `remark`) VALUES (2, 'upload_mode', '1', '上传模式', 'select', '[{\"label\":\"本地上传\",\"value\":\"1\"},{\"label\":\"阿里云OSS\",\"value\":\"2\"},{\"label\":\"七牛云\",\"value\":\"3\"},{\"label\":\"腾讯云COS\",\"value\":\"4\"}]', 99, NULL)",
        ];
        foreach ($sql as $item) {
            Db::insert($item);
        }
    }
}
