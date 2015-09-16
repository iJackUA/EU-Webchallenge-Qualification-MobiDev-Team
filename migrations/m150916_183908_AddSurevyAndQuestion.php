<?php

use yii\db\Migration;

class m150916_183908_AddSurevyAndQuestion extends Migration
{
    public function up()
    {
        $this->createTable(
            'survey',
            [
                'id' => $this->primaryKey(),
                'title' => $this->text()->notNull(),
                'desc' => $this->text(),
                'startDate' => $this->dateTime(),
                'sendDate' => $this->dateTime(),
                'expireDate' => $this->dateTime(),
                'createdBy' => $this->integer(),
                'created_at' => $this->dateTime(),
                'updated_at' => $this->dateTime(),
            ]);

        $this->createTable(
            'question',
            [
                'id' => $this->primaryKey(),
                'survey_id' => $this->integer()->notNull(),
                'title' => $this->text(),
                'type' => $this->integer(),
                'position' => $this->integer(),
                'required' => $this->boolean(),
                'meta' => "JSON DEFAULT '{}'::JSON",
                'created_at' => $this->dateTime(),
                'updated_at' => $this->dateTime(),
            ]);
    }

    public function down()
    {
        $this->dropTable('survey');
        $this->dropTable('question');

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
