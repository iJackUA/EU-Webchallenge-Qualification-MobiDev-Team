<?php

namespace app\models;

use app\models\gii\SurveyGii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\VarDumper;

/**
 * Class Survey
 *
 * @package app\models
 * @property Array $participants
 * @property Array $questions
 * @property Array $answers
 * @property Array $questionsWithAnswers
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

    public function getAnswers()
    {
        return $this->hasMany(Answer::className(), ['survey_id' => 'id']);
    }

    public function getQuestionsWithAnswers()
    {
        $questionsWithAnswers = [];
        $questions = $this->questions;
        $answers = $this->answers;

        foreach ($questions as $question) {
            $questionsWithAnswers[$question->uuid] = $question->attributes;
            $questionsWithAnswers[$question->uuid]['answers'] = [];
        }

        foreach ($answers as $answer) {
            $meta = json_decode($answer->meta, true) ?: [];
            foreach($meta as $uuid => $value) {
                if (array_key_exists($uuid, $questionsWithAnswers)) {
                    $questionsWithAnswers[$uuid]['answers'][] = $value;
                }
            }
        }

        return $questionsWithAnswers;
    }

    public function isActive(){
        if (strtotime($this->startDate) <= time() && time() <= strtotime($this->expireDate)) {
            return true;
        } else {
            return false;
        }
    }
}
