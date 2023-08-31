<?php

declare(strict_types=1);
namespace App\Backend\Controller;

use App\Backend\Request\UserRequest;
use App\Backend\Service\UserService;
use App\Backend\Vo\UserServiceVo;
use App\Common\Abstracts\AbstractsController;
use App\Common\Annotation\Auth;
use App\Common\Helper\LoginUser;
use App\Common\Interfaces\UserServiceInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * Class LoginController
 * @package Backend\System\Controller
 */
#[Controller(prefix: "backend")]
class LoginController extends AbstractsController
{
    #[Inject]
    protected UserService $systemUserService;

    #[Inject]
    protected UserServiceInterface $userService;

    /**
     * @param UserRequest $request
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    #[PostMapping("login")]
    public function login(UserRequest $request): ResponseInterface
    {
        $requestData = $request->validated();
        $vo = new UserServiceVo();
        $vo->setUsername($requestData['username']);
        $vo->setPassword($requestData['password']);
        return $this->success(['token' => $this->userService->login($vo)]);
    }

    /**
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    #[PostMapping("logout"), Auth]
    public function logout(): ResponseInterface
    {
        $this->userService->logout();
        return $this->success();
    }

    /**
     * 用户信息
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[GetMapping("getInfo"), Auth]
    public function getInfo(): ResponseInterface
    {
        return $this->success($this->systemUserService->getInfo());
    }

    /**
     * 刷新token
     * @param LoginUser $user
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    #[PostMapping("refresh")]
    public function refresh(LoginUser $user): ResponseInterface
    {
        return $this->success(['token' => $user->refresh()]);
    }

    /**
     * 获取每日的必应背景图
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    #[GetMapping("getBingBackgroundImage")]
    public function getBingBackgroundImage(): ResponseInterface
    {
        try {
            $response = file_get_contents('https://cn.bing.com/HPImageArchive.aspx?format=js&idx=0&n=1');
            $content = json_decode($response);
            if (! empty($content?->images[0]?->url)) {
                return $this->success([
                    'url' => 'https://cn.bing.com' . $content?->images[0]?->url
                ]);
            }
            throw new \Exception;
        } catch (\Exception $e) {
            return $this->error('获取必应背景失败');
        }
    }
}