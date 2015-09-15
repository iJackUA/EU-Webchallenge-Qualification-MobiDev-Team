<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use Zelenin\yii\SemanticUI\collections\Menu;
use Zelenin\yii\SemanticUI\Elements;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="ui container">
        <?php
        echo Menu::widget([
                              'items' => [
                                  [
                                      'label' => 'Home',
                                      'url' => [Yii::$app->homeUrl]
                                  ],
                                  [
                                      'label' => 'Manage:'
                                  ],
                                  [
                                      'label' => 'Users',
                                      'url' => ['/users']
                                  ],
                                  [
                                      'label' => 'Surveys',
                                      'url' => ['/surveys']
                                  ],
                              ],
                              'rightMenuItems' => [
                                  [
                                      'label' => Elements::input(\yii\helpers\Html::input('text', null, null, ['placeholder' => 'search'])),
                                      'encode' => false
                                  ],
                                  [
                                      'label' => 'Logout',
                                      'url' => ['/logout']
                                  ],
                              ]
                          ]);
        ?>
</div>

<div class="wrap">
    <div class="ui container">
    <?php
    //    NavBar::begin([
    //                      'brandLabel' => 'My Company',
    //                      'brandUrl' => Yii::$app->homeUrl,
    //                      'options' => [
    //                          'class' => 'navbar-inverse navbar-fixed-top',
    //                      ],
    //                  ]);
    //    echo Nav::widget([
    //                         'options' => ['class' => 'navbar-nav navbar-right'],
    //                         'items' => [
    //                             ['label' => 'Home', 'url' => ['/site/index']],
    //                             ['label' => 'About', 'url' => ['/site/about']],
    //                             ['label' => 'Contact', 'url' => ['/site/contact']],
    //                             Yii::$app->user->isGuest ?
    //                                 ['label' => 'Login', 'url' => ['/site/login']] :
    //                                 [
    //                                     'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
    //                                     'url' => ['/site/logout'],
    //                                     'linkOptions' => ['data-method' => 'post']
    //                                 ],
    //                         ],
    //                     ]);
    //    NavBar::end();
    ?>
    <?= $content ?>
    </div>

    <div class="ui inverted vertical footer segment form-page">
        <div class="ui container">
            <p class="pull-right">&copy; <a href="http://mobidev.biz/" target="_blank">MobiDev</a> for EuWeb
                Challenge <?= date('Y') ?></p>
        </div>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
