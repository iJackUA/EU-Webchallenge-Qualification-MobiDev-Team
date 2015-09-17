<?php
namespace app\components;

use yii\base\Widget;
use yii\helpers\Html;

class AnswerTextFieldWidget extends Widget
{
    public $question;
    public $pos;

    public function run()
    {
        $options = json_decode($this->question->meta, true);
        return '<h3>' . $this->pos . ') ' . $this->question->title . '</h3>' . Html::input('text', 'survey[' . $this->question->uuid . ']', '', $options);
    }
}
