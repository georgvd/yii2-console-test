<?php

namespace app\commands;

use app\dtos\QueueMessageDto;
use app\exceptions\QueueServiceException;
use app\services\QueueService;
use yii\console\Controller;
use yii\console\ExitCode;

class QueueController extends Controller
{
    const QUEUE_SERVICE_INTERVAL = 5; //in seconds

    /** @var QueueService */
    protected $queueService;

    public function init()
    {
        parent::init();
        $this->layout = false;
        $this->queueService = new QueueService(\Yii::$app->queue);
    }

    /**
     * Add message to queue. Paramenter: text
     */
    public function actionPush($text)
    {
        try {
            $text = $this->queueService->parseText($text);

            $dto = $this->queueService->pushMessage($text);

            echo $this->render(
                'queued',
                ['dto' => $dto, 'controller' => $this]
            );

            return ExitCode::OK;
        } catch (QueueServiceException $ex){
            echo $this->render(
                'error',
                ['controller' => $this, 'text' => "Error: ".$ex->getMessage()]
            );
            return ExitCode::DATAERR;
        }
    }

    /**
     * Serve queue continuously with interval of 5 seconds
     */
    public function actionService()
    {
        echo $this->render(
            'service_started',
            ['controller' => $this]
        );

        $this->queueService->serviceQueue(
            true,
            static::QUEUE_SERVICE_INTERVAL,
            \Closure::fromCallable([$this, 'renderMessage'])
        );

        return ExitCode::UNSPECIFIED_ERROR;
    }

    /**
     * @param QueueMessageDto $dto
     */
    protected function renderMessage(QueueMessageDto $dto)
    {
        echo $this->render('message', ['dto' => $dto, 'controller' => $this]);
    }
}

