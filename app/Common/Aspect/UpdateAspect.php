<?php


declare(strict_types=1);
namespace App\Common\Aspect;

use Hyperf\Context\Context;
use Hyperf\Di\Annotation\Aspect;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;
use Hyperf\Di\Exception\Exception;
use App\Common\PaModel;
use App\Common\PaRequest;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class UpdateAspect
 * @package Peanut\Aspect
 */
#[Aspect]
class UpdateAspect extends AbstractAspect
{
    public array $classes = [
        'Peanut\MineModel::update'
    ];

    /**
     * @param ProceedingJoinPoint $proceedingJoinPoint
     * @return mixed
     * @throws Exception
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function process(ProceedingJoinPoint $proceedingJoinPoint)
    {
        $instance = $proceedingJoinPoint->getInstance();
        // 更新更改人
        if ($instance instanceof PaModel &&
            in_array('updated_by', $instance->getFillable()) &&
            config('peanutadmin.data_scope_enabled') &&
            Context::has(ServerRequestInterface::class) &&
            container()->get(PaRequest::class)->getHeaderLine('authorization')
        ) {
            try {
                $instance->updated_by = user()->getId();
            } catch (\Throwable $e) {}
        }
        return $proceedingJoinPoint->process();
    }
}