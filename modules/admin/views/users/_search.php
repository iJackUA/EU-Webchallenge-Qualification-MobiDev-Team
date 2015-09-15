<?php

use yii\helpers\Html;
use \Zelenin\yii\SemanticUI\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SearchUser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'createdAt') ?>

    <?= $form->field($model, 'updatedAt') ?>

    <?= $form->field($model, 'username') ?>

    <?= $form->field($model, 'authKey') ?>

    <?php // echo $form->field($model, 'emailConfirmToken') ?>

    <?php // echo $form->field($model, 'passwordHash') ?>

    <?php // echo $form->field($model, 'passwordResetToken') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
