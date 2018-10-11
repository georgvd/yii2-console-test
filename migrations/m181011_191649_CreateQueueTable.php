<?php

use yii\db\Migration;

/**
 * Class m181011_191649_CreateQueueTable
 */
class m181011_191649_CreateQueueTable extends Migration
{
    public $tableName = '{{%queue}}';
    public $tableOptions;

    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'channel' => $this->string()->notNull(),
            'job' => $this->binary()->notNull(),
            'pushed_at' => $this->integer()->notNull(),
            'ttr' => $this->integer()->notNull(),
            'delay' => $this->integer()->notNull()->defaultValue(0),
            'priority' => $this->integer()->unsigned()->notNull()->defaultValue(1024),
            'reserved_at' => $this->integer(),
            'attempt' => $this->integer(),
            'done_at' => $this->integer(),
        ], $this->tableOptions);

        $this->createIndex('channel', $this->tableName, 'channel');
        $this->createIndex('reserved_at', $this->tableName, 'reserved_at');
        $this->createIndex('priority', $this->tableName, 'priority');
    }

    public function down()
    {
        echo "m181011_191649_CreateQueueTable cannot be reverted.\n";
        return false;
    }
}
