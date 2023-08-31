<?php
declare(strict_types=1);


namespace App\Backend\Service\Dependencies;

use App\Backend\Mapper\UserMapper;
use App\Backend\Model\User;
use App\Backend\Vo\UserServiceVo;
use App\Common\Event\UserLoginAfter;
use App\Common\Event\UserLoginBefore;
use App\Common\Event\UserLogout;
use App\Common\Exception\NormalStatusException;
use App\Common\Exception\UserBanException;
use App\Common\Helper\PaCode;
use App\Common\Interfaces\UserServiceInterface;
use Hyperf\Database\Model\ModelNotFoundException;

/**
 * 用户登录
 */
class UserAuthService implements UserServiceInterface
{

    /**
     * 登录
     * @param UserServiceVo $userServiceVo
     * @return string
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function login(UserServiceVo $userServiceVo): string
    {
        $mapper = container()->get(UserMapper::class);
        try {
            event(new UserLoginBefore(['username' => $userServiceVo->getUsername(), 'password' => $userServiceVo->getPassword()]));
            $userinfo = $mapper->checkUserByUsername($userServiceVo->getUsername())->toArray();
            $password = $userinfo['password'];
            unset($userinfo['password']);
            $userLoginAfter = new UserLoginAfter($userinfo);
            if ($mapper->checkPass($userServiceVo->getPassword(), $password)) {
                if (
                    ($userinfo['status'] == User::USER_NORMAL)
                    ||
                    ($userinfo['status'] == User::USER_BAN && $userinfo['id'] == env('SUPER_ADMIN'))
                ) {
                    $userLoginAfter->message = t('jwt.login_success');
                    $token = user()->getToken($userLoginAfter->userinfo);
                    $userLoginAfter->token = $token;
                    event($userLoginAfter);
                    return $token;
                } else {
                    $userLoginAfter->loginStatus = false;
                    $userLoginAfter->message = t('jwt.user_ban');
                    event($userLoginAfter);
                    throw new UserBanException;
                }
            } else {
                $userLoginAfter->loginStatus = false;
                $userLoginAfter->message = t('jwt.password_error');
                event($userLoginAfter);
                throw new NormalStatusException;
            }
        } catch (\Exception $e) {
            if ($e instanceof ModelNotFoundException) {
                throw new NormalStatusException(t('jwt.username_error'), PaCode::NO_DATA);
            }
            if ($e instanceof NormalStatusException) {
                throw new NormalStatusException(t('jwt.password_error'), PaCode::PASSWORD_ERROR);
            }
            if ($e instanceof UserBanException) {
                throw new NormalStatusException(t('jwt.user_ban'), PaCode::USER_BAN);
            }
            console()->error($e->getMessage());
            throw new NormalStatusException(t('jwt.unknown_error'));
        }
    }

    /**
     * 用户退出
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function logout()
    {
        $user = user();
        event(new UserLogout($user->getUserInfo()));
        $user->getJwt()->logout();
    }
}