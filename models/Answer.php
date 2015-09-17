<?php

namespace app\models;

use app\models\gii\AnswerGii;

class Answer extends AnswerGii
{
    public function getSurvey()
    {
        return $this->hasOne(Survey::className(), ['id' => 'survey_id']);
    }
}
