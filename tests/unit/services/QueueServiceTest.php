<?php

namespace tests\services;

use app\dtos\QueueMessageDto;
use app\jobs\QueueMessageJob;
use app\services\QueueService;
use PHPUnit\Framework\MockObject\MockObject;
use yii\queue\db\Queue;
use yii\queue\ExecEvent;

class QueueServiceTest extends \Codeception\Test\Unit
{
    /** @var Queue|MockObject */
    protected $queue;

    /** @var QueueService */
    protected $queueService;

    public function _before()
    {
        $this->queue = $this->createMock(Queue::class);
        $this->queueService = new QueueService($this->queue);
    }

    /**
     * @dataProvider providerParseTextValid
     * @param string $text
     * @param string $expected
     */
    public function testParseTextValid($text, $expected)
    {
        $this->assertEquals($expected, $this->queueService->parseText($text));
    }

    public function providerParseTextValid()
    {
        $maxStr = str_repeat('Ц', 120);
        return [
          ['asd', 'asd'],
          ['  test  ', 'test'],
          ['Проверка', 'Проверка'],
          ['П', 'П'],
          [' '.$maxStr.' ', $maxStr]
        ];
    }

    /**
     * @dataProvider providerParseTextExpectedQueueServiceException
     * @expectedException \app\exceptions\QueueServiceException
     * @param string $text
     */
    public function testParseTextExpectedQueueServiceException($text)
    {
        $this->queueService->parseText($text);
    }

    public function providerParseTextExpectedQueueServiceException()
    {
        return [
            [''],
            ['  '],
            [str_repeat('w', 120).'z'],
            [str_repeat('Ц', 120).'z']
        ];
    }

    public function testPushMessage()
    {
        $id = 100;
        $text = 'Test message';
        $this->queue
            ->expects($this->once())
            ->method('push')
            ->willReturn($id);

        $dto = $this->queueService->pushMessage($text);

        $this->assertInstanceOf(QueueMessageDto::class, $dto);
        $this->assertEquals($id, $dto->id);
        $this->assertInstanceOf(QueueMessageJob::class, $dto->job);
        $this->assertEquals($text, $dto->job->text);
        $this->assertGreaterThan(0, $dto->job->timestamp);
    }

    /**
     * @dataProvider providerManageQueue
     */
    public function testServiceQueue($isInfinityLoop, $timeout)
    {
        $this->queue
            ->expects($this->once())
            ->method('on')
            ->withAnyParameters();

        $this->queue
            ->expects($this->once())
            ->method('run')
            ->with($isInfinityLoop, $timeout);

        $fn = function(){};

        $this->queueService->serviceQueue($isInfinityLoop, $timeout, $fn);

        $refl = new \ReflectionObject($this->queueService);

        $onProcessMessage = $refl->getProperty('onProcessMessage');
        $onProcessMessage->setAccessible(true);

        $this->assertSame($fn, $onProcessMessage->getValue($this->queueService));
    }

    public function providerManageQueue()
    {
        return [
            [true, 500],
            [true, 0],
            [false, 0],
        ];
    }

    public function testOnQueueEventAfterExecute()
    {
        $event = new ExecEvent();
        $event->job = new QueueMessageJob();
        $event->id = 123400;

        /** @var QueueMessageDto $dtoResult */
        $dtoResult = null;

        $refl = new \ReflectionObject($this->queueService);

        $onProcessMessage = $refl->getProperty('onProcessMessage');
        $onProcessMessage->setAccessible(true);
        $onProcessMessage->setValue(
            $this->queueService,
            function($dto) use (&$dtoResult){
                $dtoResult = $dto;
            }
        );

        $onQueueEventAfterExecute = $refl->getMethod('onQueueEventAfterExecute');
        $onQueueEventAfterExecute->setAccessible(true);

        $onQueueEventAfterExecute->invoke($this->queueService, $event);

        $this->assertInstanceOf(QueueMessageDto::class, $dtoResult);
        $this->assertSame($dtoResult->job, $event->job);
        $this->assertEquals($dtoResult->id, $event->id);
    }
}