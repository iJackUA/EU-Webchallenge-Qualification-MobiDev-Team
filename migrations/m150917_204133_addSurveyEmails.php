<?php

use yii\db\Migration;

class m150917_204133_addSurveyEmails extends Migration
{
    public function up()
    {
        $this->addColumn('survey', 'emails', \yii\db\pgsql\Schema::TYPE_TEXT);
    }

    public function down()
    {
        $this->dropColumn('survey', 'emails');

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
