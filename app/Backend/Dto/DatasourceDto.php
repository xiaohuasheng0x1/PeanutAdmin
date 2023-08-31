<?php
namespace App\Backend\Dto;

use App\Common\Annotation\ExcelData;
use App\Common\Annotation\ExcelProperty;
use App\Common\Interfaces\PaModelExcel;

/**
 * 数据源管理Dto （导入导出）
 */
#[ExcelData]
class DatasourceDto implements PaModelExcel
{
    #[ExcelProperty(value: "主键", index: 0)]
    public string $id;

    #[ExcelProperty(value: "数据源名称", index: 1)]
    public string $source_name;

    #[ExcelProperty(value: "DSN连接字符串", index: 2)]
    public string $dsn;

    #[ExcelProperty(value: "数据库用户", index: 3)]
    public string $username;

    #[ExcelProperty(value: "数据库密码", index: 4)]
    public string $password;

    #[ExcelProperty(value: "创建者", index: 5)]
    public string $created_by;

    #[ExcelProperty(value: "更新者", index: 6)]
    public string $updated_by;

    #[ExcelProperty(value: "创建时间", index: 7)]
    public string $created_at;

    #[ExcelProperty(value: "更新时间", index: 8)]
    public string $updated_at;

    #[ExcelProperty(value: "备注", index: 9)]
    public string $remark;


}