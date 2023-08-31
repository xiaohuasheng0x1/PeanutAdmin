<?php


declare(strict_types=1);
namespace App\Common\Aspect;

use Hyperf\Di\Annotation\Aspect;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;
use App\Common\Annotation\RemoteState;
use App\Common\Exception\PaException;

/**
 * Class RemoteStateAspect
 * @package Peanut\Aspect
 */
#[Aspect]
class RemoteStateAspect extends AbstractAspect
{

    public array $annotations = [
        RemoteState::class
    ];

    /**
     * @param ProceedingJoinPoint $proceedingJoinPoint
     * @return mixed
     * @throws PaException
     */
    public function process(ProceedingJoinPoint $proceedingJoinPoint)
    {
        $remote = $proceedingJoinPoint->getAnnotationMetadata()->method[RemoteState::class];
        if (! $remote->state) {
            throw new PaException('当前功能服务已禁止使用远程通用接口', 500);
        }

        return $proceedingJoinPoint->process();
    }
}