<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Survey */

$this->title = 'Create Survey';
$this->params['breadcrumbs'][] = ['label' => 'Surveys', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    html { font-size: 14px; }
</style>
<div class="survey-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
