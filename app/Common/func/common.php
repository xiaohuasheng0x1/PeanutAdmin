<?php
// 自定义函数库

use App\Backend\Vo\QueueMessageVo;
use App\Common\Helper\Id;
use App\Common\Helper\LoginUser;
use Hyperf\Context\ApplicationContext;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\Logger\LoggerFactory;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;

if (! function_exists('container')) {

    /**
     * 获取容器实例
     * @return \Psr\Container\ContainerInterface
     */
    function container(): \Psr\Container\ContainerInterface
    {
        return ApplicationContext::getContainer();
    }

}

if (! function_exists('redis')) {

    /**
     * 获取Redis实例
     * @return \Hyperf\Redis\Redis
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    function redis(): \Hyperf\Redis\Redis
    {
        return container()->get(\Hyperf\Redis\Redis::class);
    }

}

if (! function_exists('console')) {

    /**
     * 获取控制台输出实例
     * @return StdoutLoggerInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    function console(): StdoutLoggerInterface
    {
        return container()->get(StdoutLoggerInterface::class);
    }

}

if (! function_exists('logger')) {

    /**
     * 获取日志实例
     * @param string $name
     * @return LoggerInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    function logger(string $name = 'Log'): LoggerInterface
    {
        return container()->get(LoggerFactory::class)->get($name);
    }

}

if (! function_exists('user')) {
    /**
     * 获取当前登录用户实例
     * @param string $scene
     * @return LoginUser
     */
    function user(string $scene = 'default'): LoginUser
    {
        return new LoginUser($scene);
    }
}

if (! function_exists('format_size')) {
    /**
     * 格式化大小
     * @param int $size
     * @return string
     */
    function format_size(int $size): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
        $index = 0;
        for ($i = 0; $size >= 1024 && $i < 5; $i++) {
            $size /= 1024;
            $index = $i + 1;
        }
        return round($size, 2) . $units[$index];
    }
}

if (! function_exists('lang')) {
    /**
     * 获取当前语言
     * @return string
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    function lang(): string
    {
        $acceptLanguage = container()->get(\App\Common\PaRequest::class)->getHeaderLine('accept-language');
        return str_replace('-', '_', !empty($acceptLanguage) ? explode(',',$acceptLanguage)[0] : 'zh_CN');
    }
}

if (! function_exists('t')) {
    /**
     * 多语言函数
     * @param string $key
     * @param array $replace
     * @return string
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    function t(string $key, array $replace = []): string
    {
        return __($key, $replace, lang());
    }
}

if (! function_exists('pa_collect')) {
    /**
     * 创建一个Pa的集合类
     * @param null|mixed $value
     * @return \App\Common\PaCollection
     */
    function pa_collect($value = null): \App\Common\PaCollection
    {
        return new \App\Common\PaCollection($value);
    }
}

if (! function_exists('context_set')) {
    /**
     * 设置上下文数据
     * @param string $key
     * @param $data
     * @return bool
     */
    function context_set(string $key, $data): bool
    {
        return (bool)\Hyperf\Context\Context::set($key, $data);
    }
}

if (! function_exists('context_get')) {
    /**
     * 获取上下文数据
     * @param string $key
     * @return mixed
     */
    function context_get(string $key)
    {
        return \Hyperf\Context\Context::get($key);
    }
}

if (! function_exists('snowflake_id')) {
    /**
     * 生成雪花ID
     * @param int|null $workerId
     * @return String
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    function snowflake_id(?int $workerId = null): String
    {
        return container()->get(Id::class)->getId($workerId);
    }
}

if (! function_exists('event')) {
    /**
     * 事件调度快捷方法
     * @param object $dispatch
     * @return object
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    function event(object $dispatch): object
    {
        return container()->get(EventDispatcherInterface::class)->dispatch($dispatch);
    }
}

if (! function_exists('push_queue_message')) {
    /**
     * 推送消息到队列
     * @param QueueMessageVo $message
     * @param array $receiveUsers
     * @return bool
     * @throws Throwable
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    function push_queue_message(QueueMessageVo $message, array $receiveUsers = []): bool
    {
        return container()
            ->get(\App\Backend\Service\QueueLogService::class)
            ->pushMessage($message, $receiveUsers);
    }
}

if (! function_exists('add_queue')) {
    /**
     * 添加任务到队列
     * @param \App\Backend\Vo\AmqpQueueVo $amqpQueueVo
     * @return bool
     * @throws Throwable
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    function add_queue(\App\Backend\Vo\AmqpQueueVo $amqpQueueVo): bool
    {
        return container()
            ->get(\App\Backend\Service\QueueLogService::class)
            ->addQueue($amqpQueueVo);
    }
}

if (! function_exists('env')) {

    /**
     * 获取环境变量信息
     *
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    function env(string $key, mixed $default = null): mixed
    {
        return \Hyperf\Support\env($key, $default);
    }

}

if (! function_exists('config')) {

    /**
     * 获取配置信息
     *
     * @param string $key
     * @param null|mixed $default
     * @return mixed
     */
    function config(string $key, mixed $default = null): mixed
    {
        return \Hyperf\Config\config($key, $default);
    }

}

if (! function_exists('make')) {

    /**
     * Create an object instance, if the DI container exist in ApplicationContext,
     * then the object will be created by DI container via `make()` method, if not,
     * the object will create by `new` keyword.
     */
    function make(string $name, array $parameters = [])
    {
        return \Hyperf\Support\make($name, $parameters);
    }

}

if (! function_exists('sys_config')) {

    /**
     * 获取后台系统配置
     *
     * @param string $key
     * @param null|mixed $default
     * @return mixed
     * @throws RedisException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    function sys_config(string $key, mixed $default = null): mixed
    {
        return container()->get(\App\Backend\Service\ConfigService::class)->getConfigByKey($key) ?? $default;
    }

}

if (! function_exists('sys_group_config')) {

    /**
     * 获取后台系统配置
     *
     * @param string $groupKey
     * @param null|mixed $default
     * @return mixed
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    function sys_group_config(string $groupKey, mixed $default = []): mixed
    {
        return container()->get(\App\Backend\Service\ConfigService::class)->getConfigByGroupKey($groupKey) ?? $default;
    }

}