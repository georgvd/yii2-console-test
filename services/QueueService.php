<?php

namespace app\services;

use app\dtos\QueueMessageDto;
use app\exceptions\QueueServiceException;
use app\jobs\QueueMessageJob;
use yii\queue\db\Queue;
use yii\queue\ExecEvent;

/**
 * Class QueueService - service layer for yii2-queue management
 * @package app\services
 */
class QueueService
{
    const MAX_MESSAGE_TEXT_LENGTH = 120;

    /** @var Queue */
    protected $queue;

    /** @var \Closure */
    protected $onProcessMessage;

    public function __construct(Queue $queue)
    {
        $this->queue = $queue;
    }

    /**
     * Parse and validate input text
     * @param string $text
     * @return string
     * @throws QueueServiceException
     */
    public function parseText($text)
    {
        $text = trim($text);

        if (strlen($text) == 0){
            throw new QueueServiceException("Text was not specified");
        } elseif (mb_strlen($text) > static::MAX_MESSAGE_TEXT_LENGTH){
            throw new QueueServiceException("Text length is larger then ".static::MAX_MESSAGE_TEXT_LENGTH." characters");
        }

        return $text;
    }

    /**
     * @param string $text
     * @return QueueMessageDto
     * @throws QueueServiceException
     */
    public function pushMessage($text)
    {
        $dto = new QueueMessageDto();

        $dto->job = new QueueMessageJob(['text' => $text]);
        $dto->id = (int)$this->queue->push($dto->job);

        return $dto;
    }

    /**
     * @param bool $isInfinityLoop Serve queue continuously
     * @param int $timeout Timeout between service iterations, in seconds
     * @param \Closure $onProcessMessage Call this callback when new message found in queue
     */
    public function serviceQueue($isInfinityLoop, $timeout, \Closure $onProcessMessage)
    {
        $this->onProcessMessage = $onProcessMessage;
        $this->queue->on(Queue::EVENT_AFTER_EXEC, \Closure::fromCallable([$this, 'onQueueEventAfterExecute']));
        $this->queue->run($isInfinityLoop, $timeout);
    }

    protected function onQueueEventAfterExecute(ExecEvent $event)
    {
        if ($this->onProcessMessage){
            if ($event->job instanceof QueueMessageJob) {
                $dto = new QueueMessageDto();
                $dto->job = $event->job;
                $dto->id = (int)$event->id;

                /** @var \Closure $handler */
                $handler = $this->onProcessMessage;
                $handler($dto);
            }
        }
    }

}