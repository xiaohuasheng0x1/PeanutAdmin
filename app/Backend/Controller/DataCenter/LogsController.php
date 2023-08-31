<?php

declare(strict_types=1);
namespace App\Backend\Controller\DataCenter;

use App\Backend\Service\LoginLogService;
use App\Backend\Service\OperLogService;
use App\Backend\Service\QueueLogService;
use App\Common\Abstracts\AbstractsController;
use App\Common\Annotation\Auth;
use App\Common\Annotation\OperationLog;
use App\Common\Annotation\Permission;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;

/**
 * 日志控制器
 * Class LogsController
 * @package Backend\System\Controller\Logs
 */
#[Controller(prefix: "backend/logs"), Auth]
class LogsController extends AbstractsController
{
    /**
     * 登录日志服务
     */
    #[Inject]
    protected LoginLogService $loginLogService;

    /**
     * 操作日志服务
     */
    #[Inject]
    protected OperLogService $operLogService;

    /**
     * 队列日志服务
     */
    #[Inject]
    protected QueueLogService $queueLogService;

    /**
     * 获取登录日志列表
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[GetMapping("getLoginLogPageList"), Permission("loginLog")]
    public function getLoginLogPageList(): \Psr\Http\Message\ResponseInterface
    {
        return $this->success($this->loginLogService->getPageList($this->request->all()));
    }

    /**
     * 获取操作日志列表
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[GetMapping("getOperLogPageList"), Permission("operLog")]
    public function getOperLogPageList(): \Psr\Http\Message\ResponseInterface
    {
        return $this->success($this->operLogService->getPageList($this->request->all()));
    }

    /**
     * 获取队列日志列表
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[GetMapping("getQueueLogPageList"), Permission("queueLog")]
    public function getQueueLogPageList(): \Psr\Http\Message\ResponseInterface
    {
        return $this->success($this->queueLogService->getPageList($this->request->all()));
    }

    /**
     * 删除队列日志
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[DeleteMapping("deleteQueueLog"), Permission("queueLog:delete"), OperationLog]
    public function deleteQueueLog(): \Psr\Http\Message\ResponseInterface
    {
        return $this->queueLogService->delete((array)$this->request->input('ids', [])) ? $this->success() : $this->error();
    }

    /**
     * 删除操作日志
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[DeleteMapping("deleteOperLog"), Permission("operLog:delete"), OperationLog]
    public function deleteOperLog(): \Psr\Http\Message\ResponseInterface
    {
        return $this->operLogService->delete((array) $this->request->input('ids', [])) ? $this->success() : $this->error();
    }

    /**
     * 删除登录日志
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[DeleteMapping("deleteLoginLog"), Permission("loginLog:delete"), OperationLog]
    public function deleteLoginLog(): \Psr\Http\Message\ResponseInterface
    {
        return $this->loginLogService->delete((array) $this->request->input('ids', [])) ? $this->success() : $this->error();
    }
}
