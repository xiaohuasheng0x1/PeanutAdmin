<?php


declare(strict_types=1);
namespace App\Common\Aspect;

use Hyperf\Di\Annotation\Aspect;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;
use Hyperf\Di\Exception\Exception;
use App\Common\Annotation\Auth;
use App\Common\Exception\TokenException;

/**
 * Class AuthAspect
 * @package Peanut\Aspect
 */
#[Aspect]
class AuthAspect extends AbstractAspect
{

    public array $annotations = [
        Auth::class
    ];

    /**
     * @param ProceedingJoinPoint $proceedingJoinPoint
     * @return mixed
     * @throws Exception
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function process(ProceedingJoinPoint $proceedingJoinPoint)
    {
        $scene = 'default';

        /** @var $auth Auth */
        if (isset($proceedingJoinPoint->getAnnotationMetadata()->class[Auth::class])) {
            $auth = $proceedingJoinPoint->getAnnotationMetadata()->class[Auth::class];
            $scene = $auth->scene ?? 'default';
        }

        if (isset($proceedingJoinPoint->getAnnotationMetadata()->method[Auth::class])) {
            $auth = $proceedingJoinPoint->getAnnotationMetadata()->method[Auth::class];
            $scene = $auth->scene ?? 'default';
        }

        $loginUser = user($scene);

        if (! $loginUser->check(null, $scene)) {
            throw new TokenException(t('jwt.validate_fail'));
        }

        return $proceedingJoinPoint->process();
    }
}