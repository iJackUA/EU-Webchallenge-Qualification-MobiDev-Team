<?php
/**
 * Created by PhpStorm.
 * User: ijackua
 * Date: 20.09.15
 * Time: 14:03
 */

namespace app\modules\admin\controllers;


use app\models\SearchSurvey;

class SurveyController extends BaseController
{
//    public function init()
//    {
//        \Yii::$app->getUser()->setReturnUrl(['admin/survey']);
//    }

    public function actionIndex()
    {
        $searchModel = new SearchSurvey();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams, null);

        return $this->render('//survey/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
