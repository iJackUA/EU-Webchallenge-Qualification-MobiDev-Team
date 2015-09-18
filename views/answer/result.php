<?php

use app\components\AnswerResultWidget;
use app\models\Question;

/* @var $answer app\models\Answer */
?>

<h1>Answers for <?= $answer->survey->title; ?></h1>
<h2>Email: <?= $answer->email; ?></h2>
<p class="well">
    <?= $answer->survey->desc; ?> <br /><br />
    <b>Answer date:</b> <?= $answer->created_at; ?>
</p>
<?php foreach(json_decode($answer->meta, true) as $uuid => $value) {
    $i++;
    echo AnswerResultWidget::widget(['question' => Question::getByUuid($uuid), 'pos' => $i, 'value' => $value]);
} ?>
<!--<pre><?= print_r(json_decode($answer->meta, true)); ?></pre>-->
