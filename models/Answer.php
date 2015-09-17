<?php

namespace app\models;

use app\models\gii\AnswerGii;

class Answer extends AnswerGii
{
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
