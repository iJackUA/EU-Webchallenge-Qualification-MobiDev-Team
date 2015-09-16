<?php

namespace app\models;

use app\models\gii\QuestionGii;

class Question extends QuestionGii
{
    public function getSurvey()
    {
        return $this->hasOne(Survey::className(), ['id' => 'survey_id']);
    }
}
