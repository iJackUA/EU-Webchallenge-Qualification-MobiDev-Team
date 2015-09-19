<?php
namespace app\components;

use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\base\Widget;

class AnswerAnalyticsSliderWidget extends Widget
{
    public $title;
    public $subtitle;
    public $questionMeta;
    public $answers;

    private $_data;

    public function run()
    {
        $this->setData();

        return Highcharts::widget([
            'scripts' => [
                'modules/exporting',
                'themes/grid-light',
            ],
            'options' => $this->getOptions()
        ]);
    }

    protected function getQuestionSeries()
    {
        $result = [];
        $colorIndex = 0;
        foreach ($this->_data as $answer) {
            $result[] = [
                'name' => $answer['text'],
                'y' => $answer['count'],
                'color' => new JsExpression("Highcharts.getOptions().colors[$colorIndex]"), // Jane's color
            ];
            $colorIndex++;
        }

        return $result;
    }

    protected function getOptions()
    {
        $title = $this->title ?: 'Answers';
        $options = [
            'chart' => ['type' => 'column'],
            'title' => [
                'text' => $title,
            ],
            'xAxis' => [
                'categories' => array_keys($this->_data),
                'crosshair' => true
            ],
            'yAxis' => [
                'min' => 0,
                'title' => ['text' => $title]
            ],
            'series' => [
                [
                    'name' => $title,
                    'data' => array_values($this->_data),
                    'showInLegend' => false,
                    'dataLabels' => [
                        'enabled' => true,
                    ],
                ],
            ],
            'credits' => ['enabled' => false],
            'tooltip' => [
                'pointFormat' => '{series.name}: <b>{point.y}</b>'
            ],
            'plotOptions' => [
                'column' => [
                    'allowPointSelect' => true,
                    'cursor' => 'pointer',
                    'dataLabels' => [
                        'enabled' => true,
                        'format' => '{point.y}'
                    ],
                    'borderWidth' => 0
                ]
            ],
        ];

        if ($this->subtitle) {
            $options['subtitle'] = ['text' => $this->subtitle];
        }

        return $options;
    }

    protected function setData()
    {
        $meta = json_decode($this->questionMeta);
        $data = []; // name => count
        for ($index = $meta->from; $index <= $meta->to; $index++) {
            $data[$index] = 0;
        }
        foreach ($this->answers as $answer) {
            if (array_key_exists($answer, $data)) {
                $data[$answer] += 1;
            }
        }

        $this->_data = $data;
    }
}
