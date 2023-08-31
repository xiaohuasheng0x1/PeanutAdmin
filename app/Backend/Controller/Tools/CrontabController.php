<?php

declare(strict_types=1);
namespace App\Backend\Controller\Tools;

use App\Backend\Request\CrontabRequest;
use App\Backend\Service\CrontabLogService;
use App\Backend\Service\CrontabService;
use App\Common\Abstracts\AbstractsController;
use App\Common\Annotation\Auth;
use App\Common\Annotation\OperationLog;
use App\Common\Annotation\Permission;
use App\Common\Annotation\RemoteState;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\PutMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 定时任务控制器
 * Class CrontabController
 * @package Backend\Setting\Controller\Tools
 */
#[Controller(prefix: "backend/crontab"), Auth]
class CrontabController extends AbstractsController
{
    /**
     * 计划任务服务
     */
    #[Inject]
    protected CrontabService $service;

    /**
     * 计划任务日志服务
     */
    #[Inject]
    protected CrontabLogService $logService;

    /**
     * 获取列表分页数据
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[GetMapping("index"), Permission("crontab, crontab:index")]
    public function index(): ResponseInterface
    {
        return $this->success($this->service->getPageList($this->request->all()));
    }

    /**
     * 获取日志列表分页数据
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[GetMapping("logPageList")]
    public function logPageList(): ResponseInterface
    {
        return $this->success($this->logService->getPageList($this->request->all()));
    }

    /**
     * 保存数据
     * @param CrontabRequest $request
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[PostMapping("save"), Permission("crontab:save"), OperationLog]
    public function save(CrontabRequest $request): ResponseInterface
    {
        return $this->success(['id' => $this->service->save($request->all())]);
    }

    /**
     * 立即执行定时任务
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[PostMapping("run"), Permission("crontab:run"), OperationLog]
    public function run(): ResponseInterface
    {
        $id = $this->request->input('id', null);
        if (is_null($id)) {
            return $this->error();
        } else {
            return $this->service->run($id) ? $this->success() : $this->error();
        }
    }

    /**
     * 获取一条数据信息
     * @param int $id
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[GetMapping("read/{id}"), Permission("crontab:read")]
    public function read(int $id): ResponseInterface
    {
        return $this->success($this->service->read($id));
    }

    /**
     * 更新数据
     * @param int $id
     * @param CrontabRequest $request
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[PutMapping("update/{id}"), Permission("crontab:update"), OperationLog]
    public function update(int $id, CrontabRequest $request): ResponseInterface
    {
        return $this->service->update($id, $request->all()) ? $this->success() : $this->error();
    }

    /**
     * 单个或批量删除
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[DeleteMapping("delete"), Permission("crontab:delete")]
    public function delete(): ResponseInterface
    {
        return $this->service->delete((array) $this->request->input('ids', [])) ? $this->success() : $this->error();
    }

    /**
     * 删除定时任务日志
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[DeleteMapping("deleteCrontabLog"), Permission("crontab:deleteCrontabLog"), OperationLog("删除定时任务日志")]
    public function deleteCrontabLog(): \Psr\Http\Message\ResponseInterface
    {
        return $this->logService->delete((array) $this->request->input('ids', [])) ? $this->success() : $this->error();
    }

    /**
     * 更改状态
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[PutMapping("changeStatus"), Permission("crontab:update"), OperationLog]
    public function changeStatus(): ResponseInterface
    {
        return $this->service->changeStatus((int) $this->request->input('id'), (string) $this->request->input('status'))
            ? $this->success() : $this->error();
    }

    /**
     * 远程万能通用列表接口
     * @return ResponseInterface
     */
    #[PostMapping("remote"), RemoteState(true)]
    public function remote(): ResponseInterface
    {
        return $this->success($this->service->getRemoteList($this->request->all()));
    }
}