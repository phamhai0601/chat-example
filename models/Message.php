<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "message".
 *
 * @property int $id
 * @property int $user_to
 * @property int $user_form
 * @property string $conntent
 * @property int $created_at
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'message';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_to', 'user_form', 'conntent', 'created_at'], 'required'],
            [['id', 'user_to', 'user_form', 'created_at'], 'integer'],
            [['conntent'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_to' => 'User To',
            'user_form' => 'User Form',
            'conntent' => 'Conntent',
            'created_at' => 'Created At',
        ];
    }
}
