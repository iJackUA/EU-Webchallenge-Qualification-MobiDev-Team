<?php

namespace app\models;

use app\models\gii\QuestionGii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

class Question extends QuestionGii
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

    public static function getByUuid($uuid){
        return self::find()
            ->where(['uuid' => $uuid])
            ->one();
    }
}
