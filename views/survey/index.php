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
                [
                    'attribute' => 'title',
                    'value' => function ($model, $key, $index, $column) {
                        return Html::a($model->{$column->attribute},
                                       \yii\helpers\Url::to(['survey/update', 'id' => $model->id]));
                    },
                    'format' => 'raw'
                ],
                'desc:ntext',
                [
                    'attribute' => 'startDate',
                    'value' => 'startDate',
                    'filter' => \yii\jui\DatePicker::widget([
                        'model' => $searchModel,
                        'attribute' => 'startDate',
                        'options' => [
                            'class' => 'form-control'
                        ],
                        'clientOptions' => [
                            'dateFormat' => 'dd.mm.yy',
                        ]
                    ]),
                    'format' => 'date'
                ],
                [
                    'attribute' => 'expireDate',
                    'value' => 'expireDate',
                    'filter' => \yii\jui\DatePicker::widget([
                        'model' => $searchModel,
                        'attribute' => 'expireDate',
                        'options' => [
                            'class' => 'form-control'
                        ],
                        'clientOptions' => [
                            'dateFormat' => 'dd.mm.yy',
                        ]
                    ]),
                    'format' => 'date'
                ],
                // 'createdBy',
                // 'created_at',
                // 'updated_at',
                [
                    'header' => 'Emails',
                    'value' => function ($model) {
                        $all = $model->getAllParticipantsCount();
                        $done = $model->getSentParticipantsCount();
                        return " $done/$all ".Html::a('status', ['/survey/participants', 'id' => $model->id], [
                            'class' => 'btn btn-xs btn-info',
                        ]);
                    },
                    'format' => 'raw',
                ],
                [
                    'class' => \yii\grid\ActionColumn::className(),
                    'template'=>'{analytic} {view} {update} {delete}',
                    'buttons' => [
                        'analytic' => function ($url, $model) {
                            $analyticsUrl = \yii\helpers\Url::to(['survey/analytics', 'id' => $model->id]);
                            return \yii\helpers\Html::a('<span class="glyphicon glyphicon-stats"></span>', $analyticsUrl,
                                ['title' => Yii::t('yii', 'Analytics')]);
                        }
                    ],
                ]
            ],
        ]); ?>

</div>
