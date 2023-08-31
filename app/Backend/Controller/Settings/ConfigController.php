<?php

declare(strict_types=1);
namespace App\Backend\Controller\Settings;

use App\Backend\Request\ConfigRequest;
use App\Backend\Service\ConfigService;
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
 * 系统配置控制器
 * Class ConfigController
 * @package Backend\Setting\Controller\Settings
 */
#[Controller(prefix: "backend/config"), Auth]
class ConfigController extends AbstractsController
{
    #[Inject]
    protected ConfigService $service;

    /**
     * 获取配置列表
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[GetMapping("index"), Permission("config, config:index")]
    public function index(): ResponseInterface
    {
        return $this->success($this->service->getList($this->request->all()));
    }

    /**
     * 保存配置
     * @param ConfigRequest $request
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[PostMapping("save"), Permission("config:save"), OperationLog]
    public function save(ConfigRequest $request): ResponseInterface
    {
        return $this->service->save($request->validated()) ? $this->success() : $this->error();
    }

    /**
     * 更新配置
     * @param ConfigRequest $request
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[PostMapping("update"), Permission("config:update"), OperationLog]
    public function update(ConfigRequest $request): ResponseInterface
    {
        return $this->service->updated($this->request->input('key'), $request->validated()) ? $this->success() : $this->error();
    }

    /**
     * 按 keys 更新配置
     * @param ConfigRequest $request
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[PostMapping("updateByKeys"), Permission("config:update"), OperationLog]
    public function updateByKeys(): ResponseInterface
    {
        return $this->service->updatedByKeys($this->request->all()) ? $this->success() : $this->error();
    }

    /**
     * 删除配置
     * @param string $key
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[DeleteMapping("delete"), Permission("config:delete"), OperationLog]
    public function delete(): ResponseInterface
    {
        return $this->service->delete((array) $this->request->input('ids', [])) ? $this->success() : $this->error();
    }

    /**
     * 清除配置缓存
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[PostMapping("clearCache"), Permission("config:clearCache"), OperationLog]
    public function clearCache(): ResponseInterface
    {
        return $this->service->clearCache() ? $this->success() : $this->error();
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