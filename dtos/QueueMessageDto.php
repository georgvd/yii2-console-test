<?php

namespace app\dtos;

use app\jobs\QueueMessageJob;

/**
 * Class QueueMessageDto
 * Data transfer object for QueueMessageJob
 * @package app\dtos
 */
class QueueMessageDto
{
    /** @var int An id of message */
    public $id;

    /** @var QueueMessageJob */
    public $job;
}