<?php

declare(strict_types=1);
namespace App\Common\Aspect;

use Hyperf\Di\Annotation\Aspect;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;
use Hyperf\Di\Exception\Exception;
use App\Common\Annotation\Resubmit;
use App\Common\Exception\PaException;
use App\Common\Exception\NormalStatusException;
use App\Common\PaRequest;
use App\Common\Redis\LockRedis;

/**
 * Class ResubmitAspect
 * @package Peanut\Aspect
 */
#[Aspect]
class ResubmitAspect extends AbstractAspect
{

    public array $annotations = [
        Resubmit::class
    ];

    /**
     * @param ProceedingJoinPoint $proceedingJoinPoint
     * @return mixed
     */
    public function process(ProceedingJoinPoint $proceedingJoinPoint)
    {
        try {
            $result = $proceedingJoinPoint->process();

            /** @var $resubmit Resubmit */
            if (isset($proceedingJoinPoint->getAnnotationMetadata()->method[Resubmit::class])) {
                $resubmit = $proceedingJoinPoint->getAnnotationMetadata()->method[Resubmit::class];
            }

            $request = container()->get(PaRequest::class);

            $key = md5(sprintf('%s-%s-%s', $request->ip(), $request->getPathInfo(), $request->getMethod()));

            $lockRedis = new LockRedis();
            $lockRedis->setTypeName('resubmit');

            if ($lockRedis->check($key)) {
                $lockRedis = null;
                throw new NormalStatusException($resubmit->message ?: t('peanutadmin.resubmit'), 500);
            }

            $lockRedis->lock($key, $resubmit->second);
            $lockRedis = null;

            return $result;
        } catch (\Throwable $e) {
            throw new PaException($e->getMessage(), $e->getCode());
        }
    }
}