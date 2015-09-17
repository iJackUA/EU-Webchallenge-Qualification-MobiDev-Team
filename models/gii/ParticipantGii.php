<?php

namespace app\models\gii;

use Yii;

/**
 * This is the model class for table "participant".
 *
 * @property integer $id
 * @property integer $survey_id
 * @property string $email
 * @property string $secretCode
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 */
class ParticipantGii extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'participant';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['survey_id'], 'required'],
            [['survey_id', 'status'], 'integer'],
            [['email', 'secretCode'], 'string'],
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
            'secretCode' => 'Secret Code',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @inheritdoc
     * @return \app\models\query\ParticipantQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\ParticipantQuery(get_called_class());
    }
}
