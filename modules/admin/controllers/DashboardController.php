<?php

namespace app\modules\admin\controllers;

class DashboardController extends BaseController
{
    public function actionIndex()
    {
        return $this->redirect('/user/admin',302);
        //return $this->render('index');
    }
}
