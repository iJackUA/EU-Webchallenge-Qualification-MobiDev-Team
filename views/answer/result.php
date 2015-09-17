<h1>Answers for <?= $answer->survey->title; ?></h1>
<h2>Email: <?= $answer->email; ?></h2>
<p class="well"><?= $answer->survey->desc; ?></p>
<pre><?= print_r(json_decode($answer->meta, true)); ?></pre>
