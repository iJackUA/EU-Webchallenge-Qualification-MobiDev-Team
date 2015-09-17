<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class AnswerController extends Controller
{
    /**
     * Displays a single Answer form for Survey model.
     * @param integer $id
     * @return mixed
     */
    public function actionNew($id)
    {
        return $this->render('new', [
            //'model' => $this->findModel($id),
        ]);
    }
}
