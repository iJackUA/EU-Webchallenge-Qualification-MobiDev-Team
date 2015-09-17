<?php

namespace app\models\gii;

use Yii;

/**
 * This is the model class for table "question".
 *
 * @property integer $id
 * @property integer $survey_id
 * @property string $title
 * @property integer $type
 * @property integer $position
 * @property boolean $required
 * @property string $meta
 * @property string $created_at
 * @property string $updated_at
 */
class QuestionGii extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'question';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['survey_id'], 'required'],
            [['survey_id', 'type', 'position'], 'integer'],
            [['title'], 'string'],
            [['required'], 'boolean'],
            [['created_at', 'updated_at', 'meta'], 'safe'],
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
            'title' => 'Title',
            'type' => 'Type',
            'position' => 'Position',
            'required' => 'Required',
            'meta' => 'Meta',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @inheritdoc
     * @return \app\models\query\QuestionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\QuestionQuery(get_called_class());
    }
}
