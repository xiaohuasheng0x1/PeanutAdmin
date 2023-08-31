<?php

declare(strict_types=1);
namespace App\Backend\Controller\Settings;

use App\Backend\Request\ConfigGroupRequest;
use App\Backend\Service\ConfigGroupService;
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
use Psr\Http\Message\ResponseInterface;

/**
 * 系统配置组控制器
 * Class ConfigGroupController
 * @package Backend\Setting\Controller\Settings
 */
#[Controller(prefix: "backend/configGroup"), Auth]
class ConfigGroupController extends AbstractsController
{
    #[Inject]
    protected ConfigGroupService $service;


    /**
     * 获取系统组配置
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[GetMapping("index"), Permission("config, config:index")]
    public function index(): ResponseInterface
    {
        return $this->success($this->service->getList());
    }

    /**
     * 保存配置组
     * @param ConfigGroupRequest $request
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[PostMapping("save"), Permission("config:save"), OperationLog("保存配置组")]
    public function save(ConfigGroupRequest $request): ResponseInterface
    {
        return $this->service->save($request->validated()) ? $this->success() : $this->error();
    }

    /**
     * 更新配置组
     * @param ConfigGroupRequest $request
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[PostMapping("update"), Permission("config:update"), OperationLog("更新配置组")]
    public function update(ConfigGroupRequest $request): ResponseInterface
    {
        return $this->service->update((int) $this->request->input('id'), $request->validated()) ? $this->success() : $this->error();
    }

    /**
     * 删除配置组
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[DeleteMapping("delete"), Permission("config:delete"), OperationLog("删除配置组")]
    public function delete(): ResponseInterface
    {
        return $this->service->deleteConfigGroup((int) $this->request->input('id')) ? $this->success() : $this->error();
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