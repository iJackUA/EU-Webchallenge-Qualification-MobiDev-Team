<?php
namespace app\components;

use app\models\Participant;
use Yii;
use yii\helpers\Url;
use yii\helpers\VarDumper;

class EmailSender
{
    /**
     * @var Participant
     */
    private $_participant;

    /**
     * @return Participant
     */
    public function getParticipant()
    {
        return $this->_participant;
    }

    /**
     * @param Participant $job
     */
    public function __construct(Participant $participant)
    {
        $this->_participant = $participant;
    }

    /**
     * @return bool
     */
    public function send()
    {
        $mailer = Yii::$app->mailer;
        $mailer->viewPath = '@app/mail';
        $participant = $this->_participant;
        $surveyId = $participant->survey_id;

        $url = Url::to(["/answer/new", 'id' => $surveyId, 'secretCode' => $participant->secretCode], true);
        $message = "Take the survey: <br><br><a href=\"$url\">$url</a>";

        try {
            $result = $mailer->compose(['html' => 'message'], ['message' => $message])
                ->setTo($participant->email)
                ->setFrom(Yii::$app->params['adminEmail'])
                ->setSubject("Take the survey")
                ->send();
            echo '-- SEND: ' . $result . '--';
            return true;
        } catch (\Exception $e) {
            VarDumper::dump($e->getMessage());
            return false;
        }
    }
}