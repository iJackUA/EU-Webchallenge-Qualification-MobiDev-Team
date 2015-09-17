<?php

namespace app\controllers;

use Yii;
use app\models\Answer;
use app\models\Survey;
use app\models\Participant;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;

class AnswerController extends Controller
{
    /**
     * Displays a single Answer form for Survey model.
     *
     * @param integer $id
     * @param string $secretCode
     * @return mixed
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    public function actionNew($id, $secretCode = '')
    {
        $survey = $this->findSurvey($id);
        $participant = Participant::getByCode($secretCode);
        if ($participant !== null) {
            if ($participant->survey_id != $id) {
                throw new ForbiddenHttpException('You are not a participant of this Survey!');
            }
            $answer = Answer::getBySurveyIdAndEmail($survey->id, $participant->email);
            if ($answer !== null) {
                return $this->redirect('/answer/result/' . $answer->id);
            }
        }

        return $this->render('new', [
            'survey' => $survey,
            'participant' => $participant,
            'i' => 0
        ]);
    }

    public function actionCreate($id)
    {
        if (trim(Yii::$app->request->post('email'))=='') {
            throw new ForbiddenHttpException('You must provide an email for answer!');
        }
        $survey = $this->findSurvey($id);
        $answer = Answer::getBySurveyIdAndEmail($survey->id, trim(Yii::$app->request->post('email')));
        if ($answer !== null) {
            return $this->redirect('/answer/result/' . $answer->id);
        }

        $answer = new Answer();
        $answer->survey_id = $survey->id;
        $answer->email = trim(Yii::$app->request->post('email'));
        $answer->meta = json_encode(Yii::$app->request->post('survey'));
        $answer->save();

        return $this->redirect('/answer/result/' . $answer->id);
    }

    public function actionResult($id)
    {
        $answer = $this->findModel($id);
        return $this->render('result', [
            'answer' => $answer,
        ]);
    }

    protected function findSurvey($id)
    {
        if (($model = Survey::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModel($id)
    {
        if (($model = Answer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
