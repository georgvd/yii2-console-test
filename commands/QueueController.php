<?php

namespace app\commands;

use app\dtos\QueueMessageDto;
use app\exceptions\QueueServiceException;
use app\services\QueueService;
use yii\console\Controller;
use yii\console\ExitCode;

class QueueController extends Controller
{
    /** @var QueueService */
    protected $queueService;

    public function init()
    {
        parent::init();
        $this->layout = false;
        $this->queueService = new QueueService(\Yii::$app->queue);
    }

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

    public function actionService()
    {
        echo $this->render(
            'service_started',
            ['controller' => $this]
        );

        $this->queueService->manageQueue(
            true,
            5,
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
