<?php

namespace app\models\gii;

use Yii;

/**
 * This is the model class for table "survey".
 *
 * @property integer $id
 * @property string $title
 * @property string $desc
 * @property string $startDate
 * @property string $sendDate
 * @property string $expireDate
 * @property integer $createdBy
 * @property string $created_at
 * @property string $updated_at
 */
class SurveyGii extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'survey';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title', 'desc'], 'string'],
            [['startDate', 'sendDate', 'expireDate', 'created_at', 'updated_at'], 'safe'],
            [['createdBy'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'desc' => 'Desc',
            'startDate' => 'Start Date',
            'sendDate' => 'Send Date',
            'expireDate' => 'Expire Date',
            'createdBy' => 'Created By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @inheritdoc
     * @return \app\models\query\SurveyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\SurveyQuery(get_called_class());
    }
}
