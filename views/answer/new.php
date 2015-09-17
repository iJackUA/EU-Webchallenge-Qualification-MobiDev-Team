<?php
/* @var $survey app\models\Survey */
?>
<h1><?= $survey->title; ?></h1>
<p class="well"><?= $survey->desc; ?></p>
<?php if ($survey->isActive()) { ?>
    <p>Please provide answers to the following questions:</p>
<?php } else { ?>
    <div class="alert alert-danger" role="alert">Survey is not active, please try again later!</div>
<?php } ?>
