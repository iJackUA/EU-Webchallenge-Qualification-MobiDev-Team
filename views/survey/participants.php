<?php

use app\models\Answer;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use app\components\AnswerAnalyticsRadioWidget;
use app\components\AnswerAnalyticsSliderWidget;
use app\components\AnswerAnalyticsTextFieldWidget;
use app\components\AnswerAnalyticsCheckboxesWidget;

/* @var $this yii\web\View */
/* @var $model app\models\Survey */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Surveys', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Participants';

$all = $model->getAllParticipantsCount();
$done = $model->getSentParticipantsCount();

$provider = new ArrayDataProvider([
                                      'allModels' => $model->participants,
                                  ]);
?>
<div class="survey-view">

    <h1><?= Html::encode($this->title); ?></h1>

    <h2>Emails status: <?= "<b>$done</b> from <b>$all</b>" ?></h2>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-eye-open"></span> View', ['view', 'id' => $model->id],
                    ['class' => 'btn btn-primary']); ?>
        <?= Html::a('<span class="glyphicon glyphicon-stats"></span> Analytics', ['analytics', 'id' => $model->id],
                    ['class' => 'btn btn-info']); ?>
        <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> Update', ['update', 'id' => $model->id],
                    ['class' => 'btn btn-warning']); ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]); ?>
    </p>

    <?= GridView::widget(
        [
            'dataProvider' => $provider,
            'columns' => [
                'email',
                [
                    'header' => 'Status',
                    'value' => function ($model) {
                        if ($model->status == 1) {
                            return '<span class="label label-success">Sent</span>';
                        } else {
                            return '<span class="label label-danger">In progress</span>';
                        }
                    },
                    'format' => 'raw',
                ],
                [
                    'header' => 'Link',
                    'value' => function ($model) {
                        return 'http://localhost:8888/answer/new/' . $model->survey_id . '?secretCode=' . $model->secretCode;
                    },
                    'format' => 'raw',
                ],
                [
                    'header' => 'Answer',
                    'value' => function ($model) {
                        $answer = Answer::getBySurveyIdAndEmail($model->survey_id, $model->email);
                        if ($answer !== null) {
                            return Html::a('View', ['/answer/result/' . $answer->id], [
                                'class' => 'btn btn-success',
                                'target' => '_blank'
                            ]);
                        } else {
                            return '<span class="label label-danger">No Answer</span>';
                        }
                    },
                    'format' => 'raw',
                ],
            ],
        ]); ?>
</div>
