<?php

namespace app\models;

use app\components\EmailSender;
use app\models\gii\ParticipantGii;

class Participant extends ParticipantGii
{
    const STATUS_WAIT_FOR_SEND = 0;
    const STATUS_SEND = 1;

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
