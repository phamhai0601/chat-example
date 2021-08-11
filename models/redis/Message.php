<?php

namespace app\models\redis;

use yii\redis\ActiveQuery;
use yii\redis\ActiveRecord;

class Message extends ActiveRecord
{
    public function attributes()
    {
        return ['id', 'type', 'content', 'user_id', 'user_send', 'chat_box'];
    }

    public static function find()
    {
        return new MessageQuery(get_called_class());
    }
}

class MessageQuery extends ActiveQuery
{
}
