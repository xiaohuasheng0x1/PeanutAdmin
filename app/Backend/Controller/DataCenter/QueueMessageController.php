<?php

declare(strict_types=1);
namespace App\Backend\Controller\DataCenter;

use App\Backend\Request\MessageRequest;
use App\Backend\Service\QueueMessageService;
use App\Common\Abstracts\AbstractsController;
use App\Common\Annotation\Auth;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\PutMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 信息管理控制器
 * Class MessageController
 */
#[Controller(prefix: "backend/queueMessage"), Auth]
class QueueMessageController extends AbstractsController
{
    #[Inject]
    protected QueueMessageService $service;

    /**
     * 接收消息列表
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[GetMapping("receiveList")]
    public function receiveList(): ResponseInterface
    {
        return $this->success($this->service->getReceiveMessage($this->request->all()));
    }

    /**
     * 已发送消息列表
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[GetMapping("sendList")]
    public function sendList(): ResponseInterface
    {
        return $this->success($this->service->getSendMessage($this->request->all()));
    }

    /**
     * 发私信
     * @param MessageRequest $request
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Throwable
     */
    #[PostMapping("sendPrivateMessage")]
    public function sendPrivateMessage(MessageRequest $request): ResponseInterface
    {
        return $this->service->sendPrivateMessage($request->validated()) ? $this->success() : $this->error();
    }

    /**
     * 获取接收人列表
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[GetMapping("getReceiveUser")]
    public function getReceiveUser(): ResponseInterface
    {
        return $this->success(
            $this->service->getReceiveUserList(
                (int) $this->request->input('id', 0),
                $this->request->all()
            )
        );
    }

    /**
     * 单个或批量删除数据到回收站
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[DeleteMapping("deletes")]
    public function deletes(): ResponseInterface
    {
        return $this->service->delete((array) $this->request->input('ids', [])) ? $this->success() : $this->error();
    }

    /**
     * 更新状态到已读
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[PutMapping("updateReadStatus")]
    public function updateReadStatus(): ResponseInterface
    {
        return $this->service->updateDataStatus((array) $this->request->input('ids', [])) ? $this->success() : $this->error();
    }
}
