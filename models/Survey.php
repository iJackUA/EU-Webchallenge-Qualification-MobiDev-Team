<?php

namespace app\models;

use app\models\gii\SurveyGii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * Class Survey
 *
 * @package app\models
 * @property Array $participants
 * @property Array $questions
 */
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

    public static function find()
    {
        return parent::find()->with(['participants','questions']);
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
