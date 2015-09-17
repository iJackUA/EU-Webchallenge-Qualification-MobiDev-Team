<?php

namespace app\models;

use app\components\EmailSender;
use app\models\gii\ParticipantGii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

class Participant extends ParticipantGii
{
    const STATUS_WAIT_FOR_SEND = 0;
    const STATUS_SEND = 1;

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    public function getSurvey()
    {
        return $this->hasOne(Survey::className(), ['id' => 'survey_id']);
    }

    public function sendEmail()
    {
        $sender = new EmailSender($this);
        return $sender->send();
    }
}
