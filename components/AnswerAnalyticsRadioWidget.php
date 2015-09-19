<?php
namespace app\components;

use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\base\Widget;

class AnswerAnalyticsRadioWidget extends Widget
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
            'chart' => ['type' => 'pie'],
            'title' => [
                'text' => $title,
            ],
            'series' => [
                [
                    'name' => $title,
                    'data' => $this->getQuestionSeries(),
                    'showInLegend' => true,
                    'dataLabels' => [
                        'enabled' => true,
                    ],
                ],
            ],
            'credits' => ['enabled' => false],
            'tooltip' => [
                'pointFormat' => '{series.name}: <b>{point.y} ({point.percentage:.1f}%)</b>'
            ],
            'plotOptions' => [
                'pie' => [
                    'allowPointSelect' => true,
                    'cursor' => 'pointer',
                    'dataLabels' => [
                        'enabled' => true,
                        'format' => '<b>{point.name}</b>: {point.y} ({point.percentage:.1f}%)'
                    ]
                ]
            ]
        ];

        if ($this->subtitle) {
            $options['subtitle'] = ['text' => $this->subtitle];
        }

        return $options;
    }

    protected function setData()
    {
        $data = []; // name => count
        foreach (json_decode($this->questionMeta)->options as $option) {
            $data[$option->id] = ['text' => $option->text, 'count' => 0];
        }
        foreach ($this->answers as $answer) {
            if (array_key_exists($answer, $data)) {
                $data[$answer]['count'] += 1;
            }
        }

        $this->_data = $data;
    }
}
