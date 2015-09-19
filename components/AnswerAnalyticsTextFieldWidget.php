<?php
namespace app\components;

use yii\base\Widget;

class AnswerAnalyticsTextFieldWidget extends Widget
{
    public $data;
    public $pageSize = 10;

    public function run()
    {
        $textFieldArrayProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $this->data,
            'pagination' => [
                'pageSize' => $this->pageSize,
            ],
        ]);
        return \yii\widgets\ListView::widget([
            'dataProvider' => $textFieldArrayProvider,
            'itemView' => function ($value, $key, $index, $widget) {
                return $value;
            },
        ]);
    }
}
