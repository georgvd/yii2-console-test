<?php

/** @var \app\dtos\QueueMessageDto $dto */
/** @var \yii\console\Controller $controller */

echo $controller->ansiFormat(
    "Rendering message with id: {$dto->id} (".date('r', $dto->job->timestamp).")".PHP_EOL,
    \yii\helpers\Console::BG_YELLOW
);

echo $controller->ansiFormat(
    $dto->job->text . PHP_EOL.PHP_EOL,
    \yii\helpers\Console::BG_GREEN
);
