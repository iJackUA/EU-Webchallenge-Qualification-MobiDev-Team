<?php

namespace app\commands;

use app\models\Participant;
use app\models\Survey;
use Yii;
use yii\base\Exception;
use yii\console\Controller;
use yii\helpers\VarDumper;

/**
 * This command send surveys
 */
class SendController extends Controller
{
    const USLEEP = 200000; // 0.2 second
    const ITEMS_PER_RUN = 10;

    public $defaultAction = 'send';

    /**
     * Start queue worker
     *
     * @param int $number
     */
    public function actionSend()
    {
        for ($i = 1; $i <= self::ITEMS_PER_RUN; $i++) {
            $this->runOneTask();
            usleep(self::USLEEP);
        }
    }

    public function runOneTask()
    {
        $task = null;

        $transaction = \Yii::$app->db->beginTransaction();
        try {
            /** @var Participant $task */
            $task = Participant::findBySql("
                SELECT participant.*
                FROM participant
                INNER JOIN survey on survey.id = participant.survey_id
                WHERE participant.status = " . Participant::STATUS_WAIT_FOR_SEND . "
                AND survey.\"sendDate\" >= '" . date('Y-m-d 00:00:00') . "'
                AND survey.\"sendDate\" < '" . date('Y-m-d 23:59:59') . "'
            ")->one();

            if ($task) {
                $this->out('MARK EXECUTED TASK');
                $task->updateAttributes(['status' => Participant::STATUS_SEND]);
            } else {
                $this->out('TASK NOT FOUND');
            }

            $transaction->commit();
        } catch (Exception $e) {
            $this->out('transaction->rollBack');
            $transaction->rollBack();
            $task = null;
        }

        if($task) {
            $this->out('START SEND EMAIL');
            $task->sendEmail();
        }
    }

    private function out($var)
    {
        echo PHP_EOL . $var . PHP_EOL;
    }
}
