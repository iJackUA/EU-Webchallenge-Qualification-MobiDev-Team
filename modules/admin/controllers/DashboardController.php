<?php

namespace app\modules\admin\controllers;

class DashboardController extends BaseController
{
    public function actionIndex()
    {
        return $this->redirect('/user/admin');
        //return $this->render('index');
    }
}
