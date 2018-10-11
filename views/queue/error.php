<?php

/** @var \yii\console\Controller $controller */
/** @var string $text Error text */

echo $controller->ansiFormat(
    "{$text}".PHP_EOL,
    \yii\helpers\Console::BG_RED
);
