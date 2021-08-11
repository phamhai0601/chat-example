<?php
/**
 * @see      http://www.yiiframework.com/
 *
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license   http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\redis\Message;
use Yii;
use yii\console\Controller;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 *
 * @since  2.0
 */
class HelloController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     *
     * @param string $message the message to be echoed
     *
     * @return int Exit code
     */
    public function actionIndex($message = 'hello world')
    {
        $redis = Yii::$app->redis;
        $result = $redis->executeCommand('LRANGE', ['chat_example', '0', '-1']);
        echo '<pre>';
        print_r($result);
        die();
    }

    public function actionTest()
    {
        $message = new Message();
        $message->attributes = ['type' => 'personal'];
        $message->attributes = ['content' => 'hello'];
        $message->attributes = ['user_id' => 8];
        $message->attributes = ['user_send' => 9];
        $message->attributes = ['chat_box' => 5];
        $message->save();
        echo '<pre>';
        print_r($message);
        die;
    }
}
