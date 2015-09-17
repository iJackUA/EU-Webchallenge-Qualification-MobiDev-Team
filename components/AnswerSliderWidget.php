<?php
namespace app\components;

use yii\base\Widget;
use yii\helpers\Html;
use kartik\slider\Slider;

class AnswerSliderWidget extends Widget
{
    public $question;
    public $pos;

    public function run()
    {
        $options = json_decode($this->question->meta, true);
        return "\n\n".'<h3>' . $this->pos . ') ' . $this->question->title . '</h3>' . Slider::widget([
                                                                                                  'name' => 'survey[' . $this->question->uuid . ']',
                                                                                                  'value' => intval($options['default']),
                                                                                                  'sliderColor' => Slider::TYPE_PRIMARY,
                                                                                                  'handleColor' => Slider::TYPE_INFO,
                                                                                                  'pluginOptions' => [
                                                                                                      'orientation' => 'horizontal',
                                                                                                      'handle' => 'round',
                                                                                                      'min' => intval($options['from']),
                                                                                                      'max' => intval($options['to']),
                                                                                                      'step' => 1
                                                                                                  ],
                                                                                              ]);
    }
}
