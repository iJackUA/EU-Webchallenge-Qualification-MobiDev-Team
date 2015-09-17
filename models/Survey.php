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
        $this->hasMany(Question::className(), ['survey_id' => 'id']);
    }
}
