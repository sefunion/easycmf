<?php
/**
 * 站内消息队列消费监听器.
 */
declare(strict_types=1);


namespace App\System\Listener;

use Hyperf\Event\Annotation\Listener;
use Hyperf\Event\Contract\ListenerInterface;
use Easy\Amqp\Event\AfterConsume;
use Easy\Amqp\Event\BeforeConsume;
use Easy\Amqp\Event\ConsumeEvent;
use Easy\Amqp\Event\FailToConsume;
use Easy\Amqp\Event\WaitTimeout;
use Easy\Interfaces\ServiceInterface\QueueLogServiceInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * 消费队列监听
 * Class QueueConsumeListener.
 */
#[Listener]
class QueueConsumeListener implements ListenerInterface
{
    /**
     * @Message("未消费")
     */
    public const CONSUME_STATUS_NO = 1;

    /**
     * @Message("消费中")
     */
    public const CONSUME_STATUS_DOING = 2;

    /**
     * @Message("消费成功")
     */
    public const CONSUME_STATUS_SUCCESS = 3;

    /**
     * @Message("消费失败")
     */
    public const CONSUME_STATUS_FAIL = 4;

    /**
     * @Message("消费重复")
     */
    public const CONSUME_STATUS_REPEAT = 5;

    private QueueLogServiceInterface $service;

    public function listen(): array
    {
        // 返回一个该监听器要监听的事件数组，可以同时监听多个事件
        return [
            AfterConsume::class,
            BeforeConsume::class,
            ConsumeEvent::class,
            FailToConsume::class,
            WaitTimeout::class,
        ];
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function process(object $event): void
    {
        $this->service = container()->get(QueueLogServiceInterface::class);
        if ($event->message) {
            $class = get_class($event);
            $func = lcfirst(trim(strrchr($class, '\\'), '\\'));
            $this->{$func}($event);
        }
    }

    /**
     * Description:消费前
     * User:mike.
     */
    public function beforeConsume(object $event)
    {
        $this->service->update(
            (int) $event->data['queue_id'],
            ['consume_status' => self::CONSUME_STATUS_DOING]
        );
    }

    /**
     * Description:消费中
     * User:mike.
     */
    public function consumeEvent(object $event)
    {
        // TODO...
    }

    /**
     * Description:消费后
     * User:mike.
     */
    public function afterConsume(object $event)
    {
        $this->service->update(
            (int) $event->data['queue_id'],
            ['consume_status' => self::CONSUME_STATUS_SUCCESS]
        );
    }

    /**
     * Description:消费失败
     * User:mike.
     */
    public function failToConsume(object $event)
    {
        $this->service->update(
            (int) $event->data['queue_id'],
            [
                'consume_status' => self::CONSUME_STATUS_REPEAT,
                'log_content' => $event->throwable ?: $event->throwable->getMessage(),
            ]
        );
    }
}
