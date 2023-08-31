<?php
declare(strict_types=1);


namespace App\Backend\Mapper;

use App\Backend\Model\Datasource;
use App\Common\Abstracts\AbstractMapper;
use App\Common\Exception\PaException;
use Hyperf\Database\Model\Builder;
use Hyperf\DbConnection\Db;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * 数据源管理Mapper类
 */
class DatasourceMapper extends AbstractMapper
{
    /**
     * @var Datasource
     */
    public $model;

    public function assignModel()
    {
        $this->model = Datasource::class;
    }

    /**
     * 搜索处理器
     * @param Builder $query
     * @param array $params
     * @return Builder
     */
    public function handleSearch(Builder $query, array $params): Builder
    {
        
        // 数据源名称
        if (!empty($params['source_name'])) {
            $query->where('source_name', 'like', '%'.$params['source_name'].'%');
        }

        return $query;
    }

    /**
     * 测试数据库连接
     * @param Object|array $params
     * @return array
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getDataSourceTableList(Object|array $params): array
    {
        try {
            return $this->connectionDb($params)->query('SHOW TABLE STATUS')->fetchAll();
        } catch (\Throwable $e) {
            throw new PaException($e->getMessage(), 500);
        }
    }

    /**
     * 获取创建表结构SQL
     * @param Object|array $params
     * @param string $tableName
     * @return string
     */
    public function getCreateTableSql(Object|array $params, string $tableName): string
    {
        try {
            return $this->connectionDb($params)->query(
                sprintf('SHOW CREATE TABLE %s', $tableName)
            )->fetch()['Create Table'];
        } catch (\Throwable $e) {
            throw new PaException($e->getMessage(), 500);
        }
    }

    /**
     * 通过SQL创建表
     * @param string $sql
     * @return bool
     */
    public function createTable(string $sql): bool
    {
        return Db::connection('default')->getPdo()->exec($sql) > 0;
    }

    public function connectionDb(Object|array $params): \PDO
    {
        return new \PDO($params['dsn'], $params['username'], $params['password'], [
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        ]);
    }
}