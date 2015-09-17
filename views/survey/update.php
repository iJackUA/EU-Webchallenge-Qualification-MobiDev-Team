<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Survey */

$this->title = 'Update Survey: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Surveys', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<style>
    html { font-size: 14px; }
</style>
<div class="survey-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
