<?php

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
$this->params['breadcrumbs'][] = 'Analytics';

$questionsWithAnswers = $model->questionsWithAnswers;
$answers = $model->getAnswers();
?>
<div class="survey-view">

    <h1><?= Html::encode($this->title); ?></h1>

    <h2>Total answers: <?= $answers->count(); ?></h2>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-eye-open"></span> View', ['view', 'id' => $model->id],
            ['class' => 'btn btn-primary']); ?>
        <?= Html::a('<span class="glyphicon glyphicon-user"></span> Participants '. $model->getSentParticipantsCount() . '/' . $model->getAllParticipantsCount(), ['participants', 'id' => $model->id],
                    ['class' => 'btn btn-success']); ?>
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
    <?php foreach ($questionsWithAnswers as $question) {
        switch ($question['type']) {
            case 'textfield':
                echo '<h3>' . $question['title'] . '</h3>';
                echo AnswerAnalyticsTextFieldWidget::widget(['data' => $question['answers']]);
                break;
            case 'checkboxes':
                echo AnswerAnalyticsCheckboxesWidget::widget([
                    'title' => $question['title'],
                    'questionMeta' => $question['meta'],
                    'answers' => $question['answers']
                ]);
                break;
            case 'radio':
                echo AnswerAnalyticsRadioWidget::widget([
                    'title' => $question['title'],
                    'questionMeta' => $question['meta'],
                    'answers' => $question['answers']
                ]);
                break;
            case 'slider':
                echo AnswerAnalyticsSliderWidget::widget([
                    'title' => $question['title'],
                    'questionMeta' => $question['meta'],
                    'answers' => $question['answers']
                ]);
                break;
            default:
                break;
        }
    } ?>
</div>
