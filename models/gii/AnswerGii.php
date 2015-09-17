<?php

namespace app\models\gii;

use Yii;

/**
 * This is the model class for table "answer".
 *
 * @property integer $id
 * @property integer $survey_id
 * @property string $email
 * @property string $meta
 * @property string $created_at
 * @property string $updated_at
 */
class AnswerGii extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'answer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['survey_id'], 'required'],
            [['survey_id'], 'integer'],
            [['email', 'meta'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'survey_id' => 'Survey ID',
            'email' => 'Email',
            'meta' => 'Meta',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @inheritdoc
     * @return \app\models\query\AnswerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\AnswerQuery(get_called_class());
    }
}
