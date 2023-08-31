<?php

declare(strict_types = 1);
namespace App\Backend\Controller\Tools;

use App\Backend\Request\GenerateRequest;
use App\Backend\Service\DatasourceService;
use App\Backend\Service\GenerateColumnsService;
use App\Backend\Service\GenerateTablesService;
use App\Common\Abstracts\AbstractsController;
use App\Common\Annotation\Auth;
use App\Common\Annotation\OperationLog;
use App\Common\Annotation\Permission;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\PutMapping;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * 代码生成器控制器
 * Class CodeController
 * @package Backend\Setting\Controller\Tools
 */
#[Controller(prefix: "backend/code"), Auth]
class GenerateCodeController extends AbstractsController
{
    /**
     * 信息表服务
     */
    #[Inject]
    protected GenerateTablesService $tableService;

    /**
     * 数据源处理服务
     * DatasourceService
     */
    #[Inject]
    protected DatasourceService $datasourceService;

    /**
     * 信息字段表服务
     */
    #[Inject]
    protected GenerateColumnsService $columnService;

    /**
     * 代码生成列表分页
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[GetMapping("index"), Permission("code")]
    public function index(): ResponseInterface
    {
        return $this->success($this->tableService->getPageList($this->request->All()));
    }

    /**
     * 获取数据源列表
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[GetMapping("getDataSourceList"), Permission("codes")]
    public function getDataSourceList(): ResponseInterface
    {
        return $this->success($this->datasourceService->getPageList([
            'select' => 'id as value, source_name as label'
        ]));
    }

    /**
     * 获取业务表字段信息
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[GetMapping("getTableColumns")]
    public function getTableColumns(): ResponseInterface
    {
        return $this->success($this->columnService->getList($this->request->all()));
    }

    /**
     * 预览代码
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Exception
     */
    #[GetMapping("preview"), Permission("codes:preview")]
    public function preview(): ResponseInterface
    {
        return $this->success($this->tableService->preview((int) $this->request->input('id', 0)));
    }

    /**
     * 读取表数据
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[GetMapping("readTable")]
    public function readTable(): ResponseInterface
    {
        return $this->success($this->tableService->read((int) $this->request->input('id')));
    }

    /**
     * 更新业务表信息
     * @param GenerateRequest $request
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[PostMapping("update"), Permission("codes:update")]
    public function update(GenerateRequest $request): ResponseInterface
    {
        return $this->tableService->updateTableAndColumns($request->validated()) ? $this->success() : $this->error();
    }

    /**
     * 生成代码
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[PostMapping("generate"), Permission("codes:generate"), OperationLog]
    public function generate(): ResponseInterface
    {
        return $this->_download(
            $this->tableService->generate((array) $this->request->input('ids', [])),
            'code.zip'
        );
    }

    /**
     * 加载数据表
     * @param GenerateRequest $request
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[PostMapping("loadTable"), Permission("codes:loadTable"), OperationLog]
    public function loadTable(GenerateRequest $request): ResponseInterface
    {
        return $this->tableService->loadTable($request->all()) ? $this->success() : $this->error();
    }

    /**
     * 删除代码生成表
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[DeleteMapping("delete"), Permission("codes:delete"), OperationLog]
    public function delete(): ResponseInterface
    {
        return $this->tableService->delete((array) $this->request->input('ids', [])) ? $this->success() : $this->error();
    }

    /**
     * 同步数据库中的表信息跟字段
     * @param int $id
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[PutMapping("sync/{id}"), Permission("codes:sync"), OperationLog]
    public function sync(int $id): ResponseInterface
    {
        return $this->tableService->sync($id) ? $this->success() : $this->error();
    }

    /**
     * 获取所有启用状态模块下的所有模型
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[GetMapping("getModels")]
    public function getModels(): ResponseInterface
    {
        return $this->success($this->tableService->getModels());
    }
}