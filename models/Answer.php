<?php

namespace app\models;

use app\models\gii\AnswerGii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

class Answer extends AnswerGii
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

    public function getSurvey()
    {
        return $this->hasOne(Survey::className(), ['id' => 'survey_id']);
    }

    public static function getBySurveyIdAndEmail($surveyId, $email){
        return self::find()
            ->where(['survey_id' => $surveyId])
            ->andwhere(['email' => $email])
            ->one();
    }
}
