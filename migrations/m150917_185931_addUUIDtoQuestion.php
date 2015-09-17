<?php

use yii\db\Migration;

class m150917_185931_addUUIDtoQuestion extends Migration
{
    public function up()
    {
        $this->addColumn('question', 'uuid', \yii\db\pgsql\Schema::TYPE_STRING);
        $this->createIndex('uuid_index', 'question', 'uuid');
    }

    public function down()
    {
        $this->dropColumn('question', 'uuid');
        $this->dropIndex('uuid_index', 'question');
        return true;
    }

}
