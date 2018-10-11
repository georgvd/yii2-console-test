<?php

namespace app\jobs;

use yii\base\BaseObject;
use yii\queue\JobInterface;

class QueueMessageJob extends BaseObject implements JobInterface
{
    /** @var int Timestamp of creation */
    public $timestamp;

    /** @var string User message */
    public $text;

    public function init()
    {
        parent::init();
        if (!$this->timestamp){
            $this->timestamp = time();
        }
    }

    public function execute($queue)
    {
        //Nothing to do
    }
}