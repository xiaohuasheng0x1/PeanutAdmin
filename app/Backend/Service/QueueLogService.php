<?php

declare(strict_types = 1);
namespace App\Backend\Service;

use App\Backend\Mapper\QueueLogMapper;
use App\Backend\Model\User;
use App\Backend\Queue\Producer\MessageProducer;
use App\Backend\Vo\AmqpQueueVo;
use App\Backend\Vo\QueueMessageVo;
use App\Common\Abstracts\AbstractService;
use App\Common\Amqp\DelayProducer;
use App\Common\Exception\NormalStatusException;
use Hyperf\Di\Annotation\AnnotationCollector;
use Hyperf\Di\Annotation\Inject;

/**
 * 队列管理服务类
 */
class QueueLogService extends AbstractService
{
    /**
     * @var QueueLogMapper
     */
    public $mapper;

    /**
     * @var UserService
     */
    #[Inject]
    protected UserService $userService;

    /**
     * @var DelayProducer
     */
    #[Inject]
    protected DelayProducer $producer;

    /**
     * QueueLogService constructor.
     * @param QueueLogMapper $mapper
     */
    public function __construct(QueueLogMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * 修改队列日志的生产状态
     * @return bool
     */
    public function updateProduceStatus(string $ids): bool
    {
        // TODO...
        return true;
    }

    /**
     * 添加任务到队列
     * @param AmqpQueueVo $amqpQueueVo
     * @return bool
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Throwable
     */
    public function addQueue(AmqpQueueVo $amqpQueueVo): bool
    {
        $producer = AnnotationCollector::get($amqpQueueVo->getProducer());

        $class = $amqpQueueVo->getProducer();

        if (! isset($producer['_c']['Hyperf\Amqp\Annotation\Producer'])) {
            throw new NormalStatusException(t('system.queue_annotation_not_open'), 500);
        }

        return $this->producer->produce(new $class($amqpQueueVo->getData()),
            $amqpQueueVo->getIsConfirm(),
            $amqpQueueVo->getTimeout(),
            $amqpQueueVo->getDelayTime()
        );
    }

    /**
     * 推送消息到队列
     * @param QueueMessageVo $message
     * @param array $receiveUsers
     * @return bool
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Throwable
     */
    public function pushMessage(QueueMessageVo $message, array $receiveUsers = []): bool
    {
        $producer = AnnotationCollector::get(\App\Backend\Queue\Producer\MessageProducer::class);
        $consumer = AnnotationCollector::get(\App\Backend\Queue\Consumer\MessageConsumer::class);

        if (! isset($producer['_c']['Hyperf\Amqp\Annotation\Producer']) || ! isset($consumer['_c']['Hyperf\Amqp\Annotation\Consumer'])) {
            throw new NormalStatusException(t('system.queue_annotation_not_open'), 500);
        }

        if (empty ($message->getTitle())) {
            throw new NormalStatusException(t('system.queue_missing_message_title'), 500);
        }

        if (empty ($message->getContent())) {
            throw new NormalStatusException(t('system.queue_missing_message_content_type'), 500);
        }

        if (empty ($message->getContentType())) {
            throw new NormalStatusException(t('system.queue_missing_content'), 500);
        }

        if (empty($receiveUsers)) {
            $receiveUsers = $this->userService->pluck(['status' => User::USER_NORMAL],'id');
        }

        $data = [
            'title'         => $message->getTitle(),
            'content'       => $message->getContent(),
            'content_type'  => $message->getContentType(),
            'send_by'       => $message->getSendBy() ?: user()->getId(),
            'receive_users' => $receiveUsers,
        ];

        return $this->producer->produce(
            new MessageProducer($data),
            $message->getIsConfirm(),
            $message->getTimeout(),
            $message->getDelayTime()
        );
    }
}