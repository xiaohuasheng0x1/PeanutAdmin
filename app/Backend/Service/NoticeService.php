<?php

declare(strict_types = 1);
namespace App\Backend\Service;

use App\Backend\Mapper\NoticeMapper;
use App\Backend\Mapper\UserMapper;
use App\Backend\Model\QueueMessage;
use App\Backend\Vo\QueueMessageVo;
use App\Common\Abstracts\AbstractService;
use App\Common\Annotation\Transaction;
use App\Common\Exception\NormalStatusException;

/**
 * 通知管理服务类
 */
class NoticeService extends AbstractService
{
    /**
     * @var NoticeMapper
     */
    public $mapper;

    public function __construct(NoticeMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * 保存公告
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Throwable
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[Transaction]
    public function save(array $data): int
    {
        $message = new QueueMessageVo();
        $message->setTitle($data['title']);
        $message->setContentType(
            $data['type'] === '1'
                ? QueueMessage::TYPE_NOTICE
                : QueueMessage::TYPE_ANNOUNCE
        );
        $message->setContent($data['content']);
        $message->setSendBy(user()->getId());

        // 待发送用户
        $userIds = $data['users'] ?? [];
        if (empty($userIds)) {
            $userMapper = container()->get(UserMapper::class);
            $userIds = $userMapper->pluck(['status' => \App\Common\PaModel::ENABLE]);
        }

        $pushMessageRequest = push_queue_message($message, $userIds);

        $data['message_id'] = context_get('id');

        if ($data['message_id'] !== -1 && $pushMessageRequest) {
            return parent::save($data);
        }

        throw new NormalStatusException;
    }

}
