<?php

use yii\db\Migration;

class m150917_190834_changeQuestionType extends Migration
{
    public function up()
    {
        $this->alterColumn('question', 'type', \yii\db\pgsql\Schema::TYPE_STRING);
    }

    public function down()
    {
        $this->alterColumn('question', 'type', \yii\db\pgsql\Schema::TYPE_INTEGER);

        return true;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
