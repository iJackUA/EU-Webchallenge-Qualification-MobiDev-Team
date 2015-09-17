<?php

namespace app\controllers;

use Yii;
use app\models\Survey;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class AnswerController extends Controller
{
    /**
     * Displays a single Answer form for Survey model.
     * @param integer $id
     * @return mixed
     */
    public function actionNew($id)
    {
        $survey = $this->findSurvey($id);
        return $this->render('new', [
            'survey' => $survey,
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
}
