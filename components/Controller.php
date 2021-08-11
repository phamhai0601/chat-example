<?php

namespace app\components;

use Yii;
use yii\web\Controller as WebController;

class Controller extends WebController
{
    public $user;
    public $redis;

    public function init()
    {
        parent::init();
        $this->redis = Yii::$app->redis;
        if (!Yii::$app->user->isGuest) {
            $this->user = Yii::$app->user->identity;
        } else {
            $this->user = null;
        }
    }
}
