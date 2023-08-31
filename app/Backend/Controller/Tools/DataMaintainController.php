<?php

namespace App\Backend\Controller\Tools;


use App\Backend\Service\DataMaintainService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use App\Common\Annotation\Auth;
use App\Common\Annotation\OperationLog;
use App\Common\Annotation\Permission;
use App\Common\Abstracts\AbstractsController;
use Psr\Http\Message\ResponseInterface;

/**
 * Class DataMaintainController
 * @package App\backend\Controller\Tools
 */
#[Controller(prefix: "backend/dataMaintain"), Auth]
class DataMaintainController extends AbstractsController
{
    #[Inject]
    protected DataMaintainService $service;

    /**
     * 列表
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[GetMapping("index")]
    public function index(): ResponseInterface
    {
        return $this->success($this->service->getPageList($this->request->all()));
    }

    /**
     * 详情
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[GetMapping("detailed")]
    public function detailed(): ResponseInterface
    {
        return $this->success($this->service->getColumnList($this->request->input('table', null)));
    }

    /**
     * 优化表
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[PostMapping("optimize")]
    public function optimize(): ResponseInterface
    {
        $tables = $this->request->input('tables', []);
        return $this->service->optimize($tables) ? $this->success() : $this->error();
    }

    /**
     * 清理表碎片
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[PostMapping("fragment")]
    public function fragment(): ResponseInterface
    {
        $tables = $this->request->input('tables', []);
        return $this->service->fragment($tables) ? $this->success() : $this->error();
    }
}