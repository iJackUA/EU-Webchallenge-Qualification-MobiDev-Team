<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Survey */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Surveys', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="survey-view">

    <h1><?= Html::encode($this->title) ?></h1>
<pre>Here is the embeddable js code for your survey:
    <?= Html::encode('<script src="//localhost:8888/js/embed_survey.js?survey=' . $model->id . '" async></script>'); ?>

Url:<?php $url = \yii\helpers\Url::to(['answer/new', 'id' => $model->id], true); ?>

    <a href="<?= $url; ?>" target="_blank"><?= $url; ?></a>
</pre>
    <p>
        <?= Html::a('<span class="glyphicon glyphicon-stats"></span> Analytics', ['analytics', 'id' => $model->id],
            ['class' => 'btn btn-info']); ?>
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

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title:ntext',
            'desc:ntext',
            'startDate:date',
            'sendDate:date',
            'expireDate:date',
            ['attribute' => 'owner.username', 'label' => 'Created By'],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
