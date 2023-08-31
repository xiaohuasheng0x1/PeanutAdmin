<?php

declare(strict_types=1);
namespace App\Backend\Controller;

use App\Backend\Service\DeptService;
use App\Backend\Service\LoginLogService;
use App\Backend\Service\NoticeService;
use App\Backend\Service\OperLogService;
use App\Backend\Service\PostService;
use App\Backend\Service\RoleService;
use App\Backend\Service\UploadFileService;
use App\Backend\Service\UserService;
use App\Common\Abstracts\AbstractsController;
use App\Common\Annotation\Auth;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 公共方法控制器
 * Class CommonController
 * @package Backend\System\Controller
 */
#[Controller(prefix: "backend/common"), Auth]
class CommonController extends AbstractsController
{
    #[Inject]
    protected UserService $userService;

    #[Inject]
    protected DeptService $deptService;

    #[Inject]
    protected RoleService $roleService;

    #[Inject]
    protected PostService $postService;

    #[Inject]
    protected NoticeService $noticeService;

    #[Inject]
    protected LoginLogService $loginLogService;

    #[Inject]
    protected OperLogService $operLogService;

    #[Inject]
    protected UploadFileService $service;

    /**
     * 获取用户列表
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[GetMapping("getUserList")]
    public function getUserList(): ResponseInterface
    {
        return $this->success($this->userService->getPageList($this->request->all()));
    }

    /**
     * 通过 id 列表获取用户基础信息
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[PostMapping("getUserInfoByIds")]
    public function getUserInfoByIds(): ResponseInterface
    {
        return $this->success($this->userService->getUserInfoByIds((array) $this->request->input('ids', [])));
    }

    /**
     * 获取部门树列表
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[GetMapping("getDeptTreeList")]
    public function getDeptTreeList(): ResponseInterface
    {
        return $this->success($this->deptService->getSelectTree());
    }

    /**
     * 获取角色列表
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[GetMapping("getRoleList")]
    public function getRoleList(): ResponseInterface
    {
        return $this->success($this->roleService->getList());
    }

    /**
     * 获取岗位列表
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[GetMapping("getPostList")]
    public function getPostList(): ResponseInterface
    {
        return $this->success($this->postService->getList());
    }

    /**
     * 获取公告列表
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[GetMapping("getNoticeList")]
    public function getNoticeList(): ResponseInterface
    {
        return $this->success($this->noticeService->getPageList($this->request->all()));
    }

    /**
     * 获取登录日志列表
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[GetMapping("getLoginLogList")]
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
    #[GetMapping("getOperationLogList")]
    public function getOperLogPageList(): \Psr\Http\Message\ResponseInterface
    {
        return $this->success($this->operLogService->getPageList($this->request->all()));
    }

    #[GetMapping("getResourceList")]
    public function getResourceList(): ResponseInterface
    {
        return $this->success($this->service->getPageList($this->request->all()));
    }

    /**
     * 清除所有缓存
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[GetMapping("clearAllCache")]
    public function clearAllCache(): ResponseInterface
    {
        $this->userService->clearCache((string) user()->getId());
        return $this->success();
    }
}