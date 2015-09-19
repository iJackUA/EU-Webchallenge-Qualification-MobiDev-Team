<?php

/* @var $this yii\web\View */
/* @var $model app\models\Survey */
/* @var $form yii\widgets\ActiveForm */

\app\assets\SurveyBuilderAsset::register($this);

?>


<div id="survey-builder" class="ui form">

    <button class="ui green inverted button"
            v-on="click:saveSurvey">Save
    </button>

    <div class="field">
        <label>Title</label>
        <input type="text" v-model="title">
    </div>

    <div class="field">
        <label>Description</label>
        <textarea v-model="desc" rows="3"></textarea>
    </div>

    <div class="field">
        <label>Add respondents emails</label>
        <input type="text" v-model="emails" placeholder="Coma separated lists of emails">
    </div>

    <div class="fields">
        <div class="eight wide field">
            <label>Start date</label>
            <?= yii\jui\DatePicker::widget([
                'name' => 'startDate',
                'dateFormat' => 'yyyy-MM-dd',
                'options' => ['v-model' => 'startDate'],
                'clientOptions' => ['defaultDate' => date('Y-m-d')]
            ]); ?>
        </div>
        <div class="eight wide field">
            <label>Send date</label>
            <?= yii\jui\DatePicker::widget([
                'name' => 'sendDate',
                'dateFormat' => 'yyyy-MM-dd',
                'options' => ['v-model' => 'sendDate'],
                'clientOptions' => ['defaultDate' => date('Y-m-d')]
            ]); ?>
        </div>
        <div class="eight wide field">
            <label>Expire date</label>
            <?= yii\jui\DatePicker::widget([
                'name' => 'expireDate',
                'dateFormat' => 'yyyy-MM-dd',
                'options' => ['v-model' => 'expireDate'],
                'clientOptions' => ['defaultDate' => date('Y-m-d')]
            ]); ?>
        </div>
    </div>

    <h4>Add questions...</h4>

    <div class="ui buttons ">
        <button class="ui red button"
                v-on="click:addRadio">Radio button
        </button>
        <button class="ui blue button"
                v-on="click:addCheckboxes">Checkboxes
        </button>
        <button class="ui green button"
                v-on="click:addTextfield">Textfield
        </button>
        <button class="ui yellow button"
                v-on="click:addSlider">Slider
        </button>
    </div>

    <h4 v-if="questionsExists" v-transition="expand">Questions list</h4>

    <ul class="ui form questions" v-if="questionsExists">
        <li v-repeat="q in questions" v-transition="expand">

            <builder-q-radio
                q="{{@ q}}"
                position="{{$index}}"
                v-if="q.type == 'radio'"
            ></builder-q-radio>

            <builder-q-checkboxes
                q="{{@ q}}"
                position="{{$index}}"
                v-if="q.type == 'checkboxes'"
            ></builder-q-checkboxes>

            <builder-q-textfield
                q="{{@ q}}"
                position="{{$index}}"
                v-if="q.type == 'textfield'"
            ></builder-q-textfield>

            <builder-q-slider
                q="{{@ q}}"
                position="{{$index}}"
                v-if="q.type == 'slider'"
            ></builder-q-slider>

        </li>
    </ul>


</div>
