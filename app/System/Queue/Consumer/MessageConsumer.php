<?php

declare(strict_types=1);


namespace App\System\Queue\Consumer;

use Hyperf\Amqp\Annotation\Consumer;
use Hyperf\Amqp\Message\ConsumerMessage;
use Hyperf\Amqp\Result;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * 后台内部消息队列消费处理.
 */
// #[Consumer(exchange: "easycmf", routingKey: "message.routing", queue: "message.queue", name: "message.queue", nums: 1)]
class MessageConsumer extends ConsumerMessage
{
    public function consumeMessage($data, AMQPMessage $message): Result
    {
        return parent::consumeMessage($data, $message);
    }

    public function consume($data): Result
    {
        return empty($data) ? Result::DROP : Result::ACK;
    }

    /**
     * 设置是否启动amqp.
     */
    public function isEnable(): bool
    {
        return env('AMQP_ENABLE', false);
    }
}
