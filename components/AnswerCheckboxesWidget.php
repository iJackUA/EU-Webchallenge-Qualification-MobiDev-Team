<?php
namespace app\components;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

class AnswerCheckboxesWidget extends Widget
{
    public $question;
    public $pos;

    public function run()
    {
        $items = json_decode($this->question->meta, true);
        $items = ArrayHelper::map($items['options'], 'id', 'text');
        return '<h3>' . $this->pos . ') ' . $this->question->title . '</h3>' . Html::checkboxList('survey[' . $this->question->uuid . ']', null, $items, []);
    }
}
