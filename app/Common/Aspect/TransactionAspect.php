<?php


declare(strict_types=1);
namespace App\Common\Aspect;

use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Aspect;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;
use App\Common\Annotation\Transaction;
use App\Common\Exception\PaException;

/**
 * Class TransactionAspect
 * @package Peanut\Aspect
 */
#[Aspect]
class TransactionAspect extends AbstractAspect
{
    public array $annotations = [
        Transaction::class
    ];

    /**
     * @param ProceedingJoinPoint $proceedingJoinPoint
     * @return mixed
     */
    public function process(ProceedingJoinPoint $proceedingJoinPoint)
    {
        /** @var Transaction $transaction */
        if (isset($proceedingJoinPoint->getAnnotationMetadata()->method[Transaction::class])) {
            $transaction = $proceedingJoinPoint->getAnnotationMetadata()->method[Transaction::class];
        }
        try {
            Db::beginTransaction();
            $number = 0;
            $retry  = intval($transaction->retry);
            do {
                $result = $proceedingJoinPoint->process();
                if (! is_null($result)) {
                    break;
                }
                ++$number;
            } while ($number < $retry);
            Db::commit();
        } catch (\Throwable $e) {
            Db::rollBack();
            throw new PaException($e->getMessage(), 500);
        }
        return $result;
    }
}