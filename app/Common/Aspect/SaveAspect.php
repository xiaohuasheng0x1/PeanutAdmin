<?php


declare(strict_types=1);
namespace App\Common\Aspect;

use Hyperf\Di\Annotation\Aspect;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;
use Hyperf\Di\Exception\Exception;
use App\Common\PaModel;
use App\Common\PaRequest;

/**
 * Class SaveAspect
 * @package Peanut\Aspect
 */
#[Aspect]
class SaveAspect extends AbstractAspect
{
    public array $classes = [
        'Peanut\MineModel::save'
    ];

    /**
     * @param ProceedingJoinPoint $proceedingJoinPoint
     * @return mixed
     * @throws Exception
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Exception
     */
    public function process(ProceedingJoinPoint $proceedingJoinPoint)
    {
        /** @var PaModel $instance */
        $instance = $proceedingJoinPoint->getInstance();

        if (config('peanutadmin.data_scope_enabled')) {
            try {
                $user = user();
                // 设置创建人
                if ($instance instanceof PaModel &&
                    in_array($instance->getDataScopeField(), $instance->getFillable()) &&
                    is_null($instance[$instance->getDataScopeField()])
                ) {
                    $user->check();
                    $instance[$instance->getDataScopeField()] = $user->getId();
                }

                // 设置更新人
                if ($instance instanceof PaModel && in_array('updated_by', $instance->getFillable())) {
                    $user->check();
                    $instance->updated_by = $user->getId();
                }

            } catch (\Throwable $e) {}
        }
        // 生成ID
        if ($instance instanceof PaModel &&
            !$instance->incrementing &&
            $instance->getPrimaryKeyType() === 'int' &&
            empty($instance->{$instance->getKeyName()})
        ) {
            $instance->setPrimaryKeyValue(snowflake_id());
        }
        return $proceedingJoinPoint->process();
    }
}