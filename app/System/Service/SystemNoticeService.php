<?php

declare(strict_types=1);


namespace App\System\Service;

use App\System\Mapper\SystemNoticeMapper;
use App\System\Mapper\SystemUserMapper;
use App\System\Model\SystemQueueMessage;
use App\System\Vo\QueueMessageVo;
use Easy\Abstracts\AbstractService;
use Easy\Annotation\Transaction;
use Easy\Exception\NormalStatusException;
use Easy\EasyModel;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * 通知管理服务类.
 */
class SystemNoticeService extends AbstractService
{
    /**
     * @var SystemNoticeMapper
     */
    public $mapper;

    public function __construct(SystemNoticeMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * 保存公告.
     * @throws ContainerExceptionInterface
     * @throws \Throwable
     * @throws NotFoundExceptionInterface
     */
    #[Transaction]
    public function save(array $data): int
    {
        $message = new QueueMessageVo();
        $message->setTitle($data['title']);
        $message->setContentType(
            $data['type'] === '1'
                ? SystemQueueMessage::TYPE_NOTICE
                : SystemQueueMessage::TYPE_ANNOUNCE
        );
        $message->setContent($data['content']);
        $message->setSendBy(user()->getId());

        // 待发送用户
        $userIds = $data['users'] ?? [];
        if (empty($userIds)) {
            $userMapper = container()->get(SystemUserMapper::class);
            $userIds = $userMapper->pluck(['status' => EasyModel::ENABLE]);
        }

        $pushMessageRequest = push_queue_message($message, $userIds);

        $data['message_id'] = context_get('id');

        if ($data['message_id'] !== -1 && $pushMessageRequest) {
            return parent::save($data);
        }

        throw new NormalStatusException();
    }
}
