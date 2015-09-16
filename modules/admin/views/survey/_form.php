<?php

/* @var $this yii\web\View */
/* @var $model app\models\Survey */
/* @var $form yii\widgets\ActiveForm */

\app\assets\SurveyBuilderAsset::register($this);

?>


<div id="survey-builder">

    <button class="ui green inverted button"
            v-on="click:saveSurvey">Save
    </button>

    <h4>Add</h4>

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

    <h4>Questions</h4>

    <ul class="ui form questions">
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
