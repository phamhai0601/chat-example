<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "chat_box".
 *
 * @property int    $id
 * @property int    $type
 * @property string $user_join
 * @property int    $created_at
 * @property User   $theirOne
 * @property User   $thisOne
 */
class ChatBox extends \yii\db\ActiveRecord
{
    const TYPE_PERSONAL = 1;
    const TYPE_ROOM = 2;

    public $user;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chat_box';
    }

    public function init()
    {
        if (!Yii::$app->user->isGuest) {
            $this->user = Yii::$app->user->identity;
        } else {
            $this->user = null;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'user_join', 'created_at'], 'required'],
            [['type', 'created_at'], 'integer'],
            [['user_join'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'user_join' => 'User Join',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @param ["type","user_join"] $array
     *
     * @return void
     */
    public static function newInstance($array)
    {
        $chatBox = new self();
        $chatBox->type = $array['type'];
        $chatBox->user_join = $array['user_join'];
        $chatBox->created_at = time();
        if ($chatBox->save()) {
            return $chatBox;
        } else {
            echo '<pre>';
            print_r($chatBox->errors);
            die;
        }

        return null;
    }

    public function getTheirOne()
    {
        $user_join = json_decode($this->user_join, true);
        $user_id = $user_join[0] != $this->user->id ? $user_join[0] : $user_join[1];

        return User::findOne(['id' => $user_id]);
    }

    public function getThisOne()
    {
        $user_join = json_decode($this->user_join, true);
        $user_id = $user_join[0] == $this->user->id ? $user_join[0] : $user_join[1];

        return User::findOne(['id' => $user_id]);
    }
}
