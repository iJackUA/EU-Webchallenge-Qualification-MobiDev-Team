<?php
namespace app\components;

use yii\base\Widget;
use yii\helpers\ArrayHelper;

class AnswerResultWidget extends Widget
{
    public $question;
    public $value;
    public $pos;

    public function run()
    {
        $value_text = "";
        $items = json_decode($this->question->meta, true);

        switch ($this->question->type) {
            case 'radio':
                $items = ArrayHelper::map($items['options'], 'id', 'text');
                $value_text = $items[$this->value];
                break;
            case 'checkboxes':
                $items = ArrayHelper::map($items['options'], 'id', 'text');
                foreach ($this->value as $v) {
                    $value_text .= $items[$v] . '; ';
                }
                $value_text = trim($value_text);
                break;
            case 'slider':
            case 'textfield':
                $value_text = $this->value;
                break;
        }
        return '<h3>' . $this->pos . ') ' . $this->question->title . ':</h3> ' . $value_text;
    }
}
