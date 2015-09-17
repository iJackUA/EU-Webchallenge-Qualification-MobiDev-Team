<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[\app\models\gii\ParticipantGii]].
 *
 * @see \app\models\gii\ParticipantGii
 */
class ParticipantQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \app\models\gii\ParticipantGii[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\gii\ParticipantGii|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}