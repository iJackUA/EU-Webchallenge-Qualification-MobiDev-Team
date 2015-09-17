<?php

use yii\db\Migration;

class m150917_175632_AddedParticipantTable extends Migration
{
    const TABLE_NAME = 'participant';
    const DEFAULT_SEND_STATUS = 0;

    public function up()
    {
        $this->createTable(
            self::TABLE_NAME,
            [
                'id' => $this->primaryKey(),
                'survey_id' => $this->integer()->notNull(),
                'email' => $this->text(),
                'secretCode' => $this->text(),
                'status' => $this->smallInteger()->defaultValue(self::DEFAULT_SEND_STATUS),
                'created_at' => $this->dateTime(),
                'updated_at' => $this->dateTime(),
            ]);
    }

    public function down()
    {
        $this->dropTable(self::TABLE_NAME);
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
