<?php

namespace app\models;

use app\models\gii\SurveyGii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

class Survey extends SurveyGii
{
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('NOW()'),
            ],
        ];
    }


    public function getQuestions()
    {
        return $this->hasMany(Question::className(), ['survey_id' => 'id']);
    }

    public function getParticipants()
    {
        return $this->hasMany(Participant::className(), ['survey_id' => 'id']);
    }

    public function isActive(){
        if (strtotime($this->startDate) <= time() && time() <= strtotime($this->expireDate)) {
            return true;
        } else {
            return false;
        }
    }
}
