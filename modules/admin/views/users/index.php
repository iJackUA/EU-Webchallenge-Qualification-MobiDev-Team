<?php

use yii\helpers\Html;
use \Zelenin\yii\SemanticUI\widgets\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchUser */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'createdAt',
            'updatedAt',
            'username',
            'authKey',
            // 'emailConfirmToken:email',
            // 'passwordHash',
            // 'passwordResetToken',
            // 'email:email',
            // 'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
