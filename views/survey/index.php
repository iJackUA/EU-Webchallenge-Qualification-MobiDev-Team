<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchSurvey */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Surveys';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="survey-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Survey', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget(
        [
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'title:ntext',
                [
                    'attribute' => 'title',
                    'value' => function ($model, $key, $index, $column) {
                        return Html::a($model->{$column->attribute},
                                       \yii\helpers\Url::to(['survey/update', 'id' => $model->id]));
                    },
                    'format' => 'raw'
                ],
                'desc:ntext',
                'startDate',
                'sendDate',
                // 'expireDate',
                // 'createdBy',
                // 'created_at',
                // 'updated_at',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>

</div>
