<?php

namespace app\controllers;

use app\lib\ArraySerializer;
use app\models\Participant;
use app\models\Question;
use Yii;
use app\models\Survey;
use app\models\SearchSurvey;
use yii\base\Security;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\VarDumper;
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
    public function actionIndex($id = null)
    {
        $userId = $id ?: Yii::$app->getUser()->getId();
        $searchModel = new SearchSurvey();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $userId);

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
                'emails' => implode(', ', ArrayHelper::getColumn($survey->participants, 'email')),
                'startDate' => (new \DateTime($survey->startDate))->format("Y-m-d"),
                'sendDate' => (new \DateTime($survey->sendDate))->format("Y-m-d"),
                'expireDate' => (new \DateTime($survey->expireDate))->format("Y-m-d"),
                'questions' => $fractal->createData($questionItems)->toArray()
            ];
        });


        Yii::$app->gon->send('survey', $fractal->createData($surveyItem)->toArray());
        Yii::$app->gon->send('saveSurveyUrl', Url::to(['/survey/save-update', 'id' => $id]));
        Yii::$app->gon->send('afterSaveSurveyRedirectUrl', \Yii::$app->getUser()->getReturnUrl());

        return $this->render('update', [
            'model' => $survey,
        ]);

    }

    public function actionSaveUpdate($id)
    {
        $survey = $this->saveSurvey($id);
        $this->syncQuestions($survey);
        $this->syncParticipants($survey);
    }

    public function actionSaveNew()
    {
        $questions = Yii::$app->request->getBodyParam('questions');

        $survey = $this->saveSurvey();

        if (count($questions) > 0) {
            foreach ($questions as $key => $val) {
                $this->saveQuestion($val, $survey);
            }
        }

        $emailsString = Yii::$app->request->getBodyParam('emails');
        $emails = explode(',', $emailsString);

        if (count($emails) > 0) {
            foreach ($emails as $email) {
                $email = trim($email);
                if (strlen($email) > 0) {
                    $this->saveParticipant($email, $survey);
                }
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
     * @param $id
     * @return mixed
     */
    public function actionAnalytics($id)
    {
        $model = $this->findModel($id);
//        VarDumper::dump($model->questionsWithAnswers, 10, true);
//        die();

        return $this->render('analytics', [
            'model' => $model,
        ]);
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

    protected function saveSurvey($id = null)
    {
        $survey = is_null($id) ? new Survey() : $this->findModel($id);
        $survey->title = Yii::$app->request->getBodyParam('title');
        $survey->desc = Yii::$app->request->getBodyParam('desc');
        $survey->startDate = Yii::$app->request->getBodyParam('startDate');
        $survey->sendDate = Yii::$app->request->getBodyParam('sendDate');
        $survey->expireDate = Yii::$app->request->getBodyParam('expireDate');
        $survey->createdBy = Yii::$app->user->id;
        $survey->save();
        return $survey;
    }

    protected function saveQuestion($qData, $survey, $uuid = null)
    {
        $q = is_null($uuid) ? new Question() : Question::findOne(['uuid' => $uuid]);
        $q->title = ArrayHelper::getValue($qData, 'title');
        $q->required = ArrayHelper::getValue($qData, 'required');
        $q->position = ArrayHelper::getValue($qData, 'position');
        $q->uuid = ArrayHelper::getValue($qData, 'uuid');
        $q->type = ArrayHelper::getValue($qData, 'type');
        $q->meta = json_encode(ArrayHelper::getValue($qData, 'meta'));
        $q->survey_id = $survey->id;
        $q->save();
        return $q;
    }

    protected function saveParticipant($email, $survey)
    {
        $participant = new Participant();
        $participant->email = trim($email);
        $participant->survey_id = $survey->id;
        $participant->secretCode = (new Security)->generateRandomString();
        $participant->save();
        return $participant;
    }

    protected function syncQuestions($survey)
    {
        $questions = Yii::$app->request->getBodyParam('questions');

        $newQModels = ArrayHelper::index($questions, 'uuid');

        $newUUIDs = ArrayHelper::getColumn($questions, 'uuid');
        $existingUUIDs = ArrayHelper::getColumn($survey->questions, 'uuid');

        $uuidsToCreate = array_diff($newUUIDs, $existingUUIDs);
        $uuidsToUpdate = array_intersect($newUUIDs, $existingUUIDs);
        $uuidsToDelete = array_diff($existingUUIDs, $newUUIDs);

        if ($uuidsToCreate > 0) {
            foreach ($uuidsToCreate as $uuid) {
                $this->saveQuestion($newQModels[$uuid], $survey);
            }
        }

        if ($uuidsToUpdate > 0) {
            foreach ($uuidsToUpdate as $uuid) {
                $this->saveQuestion($newQModels[$uuid], $survey, $uuid);
            }
        }

        if ($uuidsToDelete > 0) {
            foreach ($uuidsToDelete as $uuid) {
                Question::deleteAll(['uuid' => $uuid]);
            }
        }
    }

    protected function syncParticipants(Survey $survey)
    {
        $emailsString = Yii::$app->request->getBodyParam('emails');
        $newEmails = explode(',', $emailsString);
        $newEmails = array_map(function ($email) {
            return trim($email);
        }, $newEmails);

        $existingParticipants = $survey->participants;
        $existingParticipantsModels = ArrayHelper::index($survey->participants, 'email');
        $existingEmails = ArrayHelper::getColumn($existingParticipants, 'email');

        $emailsToCreate = array_diff($newEmails, $existingEmails);
        $emailsToDelete = array_diff($existingEmails, $newEmails);

        if ($emailsToCreate > 0) {
            foreach ($emailsToCreate as $email) {
                $this->saveParticipant($email, $survey);
            }
        }

        if ($emailsToDelete > 0) {
            foreach ($emailsToDelete as $email) {
                $existingParticipantsModels[$email]->delete();
            }
        }
    }
}
