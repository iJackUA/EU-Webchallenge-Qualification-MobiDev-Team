<?php

namespace app\controllers;

use app\lib\ArraySerializer;
use app\models\Question;
use Yii;
use app\models\Survey;
use app\models\SearchSurvey;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use League\Fractal;

/**
 * SurveyController implements the CRUD actions for Survey model.
 */
class SurveyController extends Controller
{
    public function behaviors()
    {
        return array_merge_recursive(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ]
        ]);
    }

    /**
     * Lists all Survey models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchSurvey();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Survey model.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Survey model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Survey();

        Yii::$app->gon->send('saveSurveyUrl', '/survey/save-new');
        Yii::$app->gon->send('afterSaveSurveyRedirectUrl', \Yii::$app->getUser()->getReturnUrl());

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Survey model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $survey = $this->findModel($id);

        $fractal = new Fractal\Manager();
        $fractal->setSerializer(new ArraySerializer());

        $questionItems = new Fractal\Resource\Collection($survey->questions, function (Question $q) {
            return [
                'title' => $q->title,
                'required' => $q->required,
                'position' => $q->position,
                'uuid' => $q->uuid,
                'type' => $q->type,
                'meta' => json_decode($q->meta),
                'survey_id' => $q->survey_id
            ];
        });

        $surveyItem = new Fractal\Resource\Item($survey, function (Survey $survey) use ($fractal, $questionItems) {
            return [
                'title' => $survey->title,
                'desc' => $survey->desc,
                'emails' => $survey->emails,
                'startDate' => $survey->startDate,
                'expireDate' => $survey->expireDate,
                'questions' => $fractal->createData($questionItems)->toArray()
            ];
        });


        Yii::$app->gon->send('survey', $fractal->createData($surveyItem)->toArray());
        Yii::$app->gon->send('saveSurveyUrl', '/survey/save-update');
        Yii::$app->gon->send('afterSaveSurveyRedirectUrl', \Yii::$app->getUser()->getReturnUrl());

        return $this->render('update', [
            'model' => $survey,
        ]);

    }

    public function actionSaveUpdate()
    {

    }

    public function actionSaveNew()
    {
        $questions = Yii::$app->request->getBodyParam('questions');

        $survey = new Survey();
        $survey->title = Yii::$app->request->getBodyParam('title');
        $survey->desc = Yii::$app->request->getBodyParam('desc');
        $survey->startDate = Yii::$app->request->getBodyParam('startDate');
        $survey->expireDate = Yii::$app->request->getBodyParam('expireDate');
        $survey->createdBy = Yii::$app->user->id;
        $survey->save();

        if (count($questions) > 0) {
            foreach ($questions as $key => $val) {
                $q = new Question();
                $q->title = ArrayHelper::getValue($val, 'title');
                $q->required = ArrayHelper::getValue($val, 'required');
                $q->position = ArrayHelper::getValue($val, 'position');
                $q->uuid = ArrayHelper::getValue($val, 'uuid');
                $q->type = ArrayHelper::getValue($val, 'type');
                $q->meta = json_encode(ArrayHelper::getValue($val, 'meta'));
                $q->survey_id = $survey->id;
                $q->save();
            }
        }

    }

    /**
     * Deletes an existing Survey model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Survey model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     * @return Survey the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Survey::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
