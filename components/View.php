<?php
namespace app\components;

use Yii;
use yii\web\View as WebView;

class View extends WebView
{
    public $user;
    public function init()
    {
        parent::init();
        if (!Yii::$app->user->isGuest) {
            $this->user = Yii::$app->user->identity;
        } else {
            $this->user = null;
        }
    }
}