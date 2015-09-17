<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[\app\gii\models\Answer]].
 *
 * @see \app\gii\models\Answer
 */
class AnswerQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \app\gii\models\Answer[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\gii\models\Answer|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}