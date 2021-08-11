<?php

namespace app\controllers;

use app\components\Controller;
use app\form\LoginForm;
use app\form\RegisterForm;
use app\models\ChatBox;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Response;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'index', 'create-chat-box'],
                'rules' => [
                    [
                        'actions' => ['logout', 'index', 'create-chat-box'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $listChatBox = ChatBox::find()->where(['like', 'user_join', $this->user->id])->all();

        return $this->render('index', ['chatBoxs' => $listChatBox]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Đăng kí tài khoản mới.
     *
     * @return void
     */
    public function actionRegister()
    {
        $model = new RegisterForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->register()) {
                Yii::$app->session->setFlash('success', 'Register <b>'.$model->username.'</b> successfull.');

                return $this->redirect(['site/login']);
            }
            Yii::$app->session->setFlash('danger', 'An error occurred.');

            return $this->refresh();
        }

        return $this->render('register', ['model' => $model]);
    }

    /**
     * Tạo chát box.
     *
     * @return void
     */
    public function actionCreateChatBox()
    {
        if (!isset($_REQUEST['email']) || $_REQUEST['email'] == '') {
            Yii::$app->session->setFlash('danger', 'An error occurred.');

            return $this->redirect(['index']);
        } else {
            $email = $_REQUEST['email'];
            $user_join = [];
            $user = User::findOne(['email' => $email]);
            if ($user) {
                $user_join[] = $this->user->id;
                $user_join[] = $user->id;
                $chatBox = ChatBox::newInstance([
                    'type' => ChatBox::TYPE_PERSONAL,
                    'user_join' => json_encode($user_join),
                ]);
                if ($chatBox) {
                    Yii::$app->session->setFlash('success', 'Create chat box successfully.');

                    return $this->redirect(['index']);
                }
            }
            Yii::$app->session->setFlash('danger', 'Email not found on system.');

            return $this->redirect(['index']);
        }
    }

    public function actionGetMessage($chat_box_id)
    {
        Yii::$app->response->format = 'json';
        $result = $this->redis->executeCommand('LRANGE', [$chat_box_id, '0', '-1']);

        return $result;
    }

    
    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
