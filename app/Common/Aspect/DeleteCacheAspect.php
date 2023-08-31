<?php


declare(strict_types=1);
namespace App\Common\Aspect;

use Hyperf\Config\Annotation\Value;
use Hyperf\Di\Annotation\Aspect;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;
use Hyperf\Di\Exception\Exception;
use App\Common\Annotation\DeleteCache;
use App\Common\Helper\Str;

/**
 * Class DeleteCacheAspect
 * @package Peanut\Aspect
 */
#[Aspect]
class DeleteCacheAspect extends AbstractAspect
{
    public array $annotations = [
        DeleteCache::class
    ];

    /**
     * 缓存前缀
     */
    #[Value("cache.default.prefix")]
    protected string $prefix;

    /**
     * @param ProceedingJoinPoint $proceedingJoinPoint
     * @return mixed
     * @throws Exception
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function process(ProceedingJoinPoint $proceedingJoinPoint)
    {
        $redis = redis();

        /** @var DeleteCache $deleteCache */
        $deleteCache = $proceedingJoinPoint->getAnnotationMetadata()->method[DeleteCache::class];

        $result = $proceedingJoinPoint->process();

        if ( !empty($deleteCache->keys)) {
            $keys = explode(',', $deleteCache->keys);
            $iterator = null;
            $n = [];
            foreach ($keys as $key) {
                if (! Str::contains($key, '*')) {
                    $n[] = $this->prefix . $key;
                } else {
                    while (false !== ($k = $redis->scan($iterator, $this->prefix . $key, 100))) {
                        $redis->del($k);
                    }
                }
            }
            $redis->del($n);
        }

        return $result;
    }
}