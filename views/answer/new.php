<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\components\AnswerRadioWidget;
use app\components\AnswerCheckboxesWidget;
use app\components\AnswerSliderWidget;
use app\components\AnswerTextFieldWidget;

/* @var $survey app\models\Survey */
?>
<h1><?= $survey->title; ?></h1>
<p class="well"><?= $survey->desc; ?></p>

<?php if ($survey->isActive()) { ?>
    <p>Please provide answers to the following questions:</p>

    <?php $form = ActiveForm::begin(); ?>

    <?php if ($survey->questions) foreach($survey->questions as $q) {
        $i++;
        ?>
        <?php switch($q->type) {
            case 'radio':
                echo AnswerRadioWidget::widget(['question' => $q, 'pos' => $i]);
                break;
            case 'checkboxes':
                echo AnswerCheckboxesWidget::widget(['question' => $q, 'pos' => $i]);
                break;
            case 'slider':
                echo AnswerSliderWidget::widget(['question' => $q, 'pos' => $i]);
                break;
            case 'textfield':
                echo AnswerTextFieldWidget::widget(['question' => $q, 'pos' => $i]);
                break;
        } ?>
    <?php } ?>

    <br /><br /><br />
    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

<?php } else { ?>

    <div class="alert alert-danger" role="alert">Survey is not active, please try again later!</div>

<?php } ?>
