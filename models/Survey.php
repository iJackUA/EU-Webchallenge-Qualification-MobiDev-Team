<?php

namespace app\models;

use app\models\gii\SurveyGii;

class Survey extends SurveyGii
{
    public function getQuestions()
    {
        $this->hasMany(Question::className(), ['survey_id' => 'id']);
    }

    public function getParticipants()
    {
        $this->hasMany(Participant::className(), ['survey_id' => 'id']);
    }
}
