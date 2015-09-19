<?php
namespace app\components;

use miloschuman\highcharts\Highcharts;
use yii\base\Widget;
use yii\helpers\ArrayHelper;

class AnswerAnalyticsCheckboxesWidget extends Widget
{
    public $title;
    public $subtitle;
    public $questionMeta;
    public $answers;

    private $_data;

    public function run()
    {
        $this->setData();

        $seriesName = $this->title ?: 'Answers';
        $options = ArrayHelper::merge($this->getDefaultOptions(), [
            'xAxis' => [
                'categories' => [$seriesName],
                'labels' => [
                    'rotation' => -90
                ],
                'title' => ['text' => null]
            ],
            'series' => $this->getQuestionSeries()
        ]);

        return Highcharts::widget(['options' => $options]);
    }

    protected function getQuestionSeries()
    {
        return array_values(array_map(function ($row) {
            return ['name' => $row['text'], 'data' => [$row['count']]];
        }, $this->_data));
    }

    protected function getDefaultOptions()
    {
        $title = $this->title ?: 'Answers';
        $options = [
            'chart' => ['type' => 'bar'],
            'yAxis' => [
                'min' => 0,
                'title' => ['text' => 'Count', 'align' => 'high'],
                'labels' => ['overflow' => 'justify']
            ],
            'plotOptions' => [
                'bar' => ['dataLabels' => ['enabled' => true]]
            ],
            'legend' => [
                'layout' => 'vertical',
                'title' => [
                    'text' => $title . ':<br/><span style="font-size: 9px; color: #666; font-weight: normal">(Click to hide)</span>',
                    'style' => ['fontStyle' => 'italic']
                ],
                'align' => 'right',
                'verticalAlign' => 'top',
                'x' => -40,
                'y' => 80,
                'floating' => true,
                'borderWidth' => 1,
                'shadow' => true
            ],
            'credits' => ['enabled' => false],
        ];

        if ($this->title) {
            $options['title'] = ['text' => $title];
        }

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
            foreach ($answer as $option) {
                if (array_key_exists($option, $data)) {
                    $data[$option]['count'] += 1;
                }
            }
        }
        $this->_data = $data;
    }
}
