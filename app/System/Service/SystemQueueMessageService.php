<?php

declare(strict_types=1);


namespace App\System\Service;

use App\System\Mapper\SystemQueueMessageMapper;
use App\System\Model\SystemQueueMessage;
use App\System\Vo\QueueMessageVo;
use Easy\Abstracts\AbstractService;
use Easy\Annotation\DependProxy;
use Easy\Interfaces\ServiceInterface\QueueMessageServiceInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * 信息管理服务类.
 */
#[DependProxy(values: [QueueMessageServiceInterface::class])]
class SystemQueueMessageService extends AbstractService implements QueueMessageServiceInterface
{
    /**
     * @var SystemQueueMessageMapper
     */
    public $mapper;

    public function __construct(SystemQueueMessageMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * 获取用户未读消息.
     * @return mixed
     */
    public function getUnreadMessage(int $id)
    {
        $params = [
            'user_id' => $id,
            'orderBy' => 'created_at',
            'orderType' => 'desc',
            'getReceive' => true,
            'read_status' => 1,
        ];
        return $this->mapper->getPageList($params, false);
    }

    /**
     * 获取收信箱列表数据.
     */
    public function getReceiveMessage(array $params = []): array
    {
        $params['getReceive'] = true;
        unset($params['getSend']);
        return $this->mapper->getPageList($params, false);
    }

    /**
     * 获取已发送列表数据.
     */
    public function getSendMessage(array $params = []): array
    {
        $params['getSend'] = true;
        unset($params['getReceive']);
        return $this->mapper->getPageList($params, false);
    }

    /**
     * 发私信
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws \Throwable
     */
    public function sendPrivateMessage(array $data): bool
    {
        $queueMessage = new QueueMessageVo();
        $queueMessage->setTitle($data['title']);
        $queueMessage->setContent($data['content']);
        // 固定私信类型
        $queueMessage->setContentType(SystemQueueMessage::TYPE_PRIVATE_MESSAGE);
        $queueMessage->setSendBy(user()->getId());
        return push_queue_message($queueMessage, $data['users']) !== -1;
    }

    /**
     * 获取接收人列表.
     */
    public function getReceiveUserList(int $id, array $params = []): array
    {
        return $this->mapper->getReceiveUserList($id, $params);
    }

    /**
     * 更新中间表数据状态
     */
    public function updateDataStatus(array $ids, string $columnName = 'read_status', int $value = 2): bool
    {
        return $this->mapper->updateDataStatus($ids, $columnName, $value);
    }
}
