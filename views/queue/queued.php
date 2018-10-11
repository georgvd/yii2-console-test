<?php

/** @var \yii\console\Controller $controller */
/** @var \app\dtos\QueueMessageDto $dto */

$d = date("r", $dto->job->timestamp);

echo $controller->ansiFormat(
    "You message was successfully queued with id {$dto->id} at {$d}" . PHP_EOL,
    \yii\helpers\Console::BG_GREEN
);
