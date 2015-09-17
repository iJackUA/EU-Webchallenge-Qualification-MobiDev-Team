<?php

use yii\db\Migration;

class m150917_145444_create_answer_table extends Migration
{
    public function up()
    {
        $this->createTable(
            'answer',
            [
                'id' => $this->primaryKey(),
                'survey_id' => $this->integer()->notNull(),
                'email' => $this->text(),
                'meta' => "JSON DEFAULT '{}'::JSON",
                'created_at' => $this->dateTime(),
                'updated_at' => $this->dateTime(),
            ]);
    }

    public function down()
    {
        $this->dropTable('answer');

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
