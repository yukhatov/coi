<?php

namespace app\controllers;

use app\models\RegisterForm;
use app\models\ResetPasswordForm;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\helpers\Url;


use app\models\EmailManager;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
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
     * @inheritdoc
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
        if(isset(Yii::$app->user->identity))
        {
            if(Yii::$app->user->identity->group == USER::GROUP_ADMIN)
            {
                return $this->redirect('index.php?r=admin');
            }

            if(Yii::$app->user->identity->group == USER::GROUP_USER)
            {
                return $this->redirect('index.php?r=user');
            }
        }

        return $this->render('index');
    }

    /**
     * Displays main.
     *
     * @return string
     */
    public function actionMain()
    {
        return $this->render('index');
    }

    /**
     * Displays reset password form.
     *
     * @return string
     */
    public function actionReset()
    {
        $model = new ResetPasswordForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = User::findByUsername($model->username);

            if($user){
                $password = $this->sendResetEmail($model->username);

                if($password)
                {
                    $user->setPassword($password);
                    $user->save();

                    return $this->render('reset-confirm');
                }
            }
        }

        return $this->render('reset', ['model' => $model]);
    }

    public function actionRegister()
    {
        $model = new RegisterForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = new User($model);
            $user->save();

            if($this->sendConfirmEmail($user->getUsername())){
                $result = 'Confirm your email';
            }else{
                $result = 'Register failed';
            }

            return $this->render('register-confirm', ['result' => $result]);
        } else {
            return $this->render('register', ['model' => $model]);
        }
    }

    public function actionConfirm(){
        if(Yii::$app->request->get('id') and $user = User::findOne(Yii::$app->request->get('id')))
        {
            $user->setGroup(User::GROUP_USER);
            $user->save();

            return $this->goHome();
        }
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goHome();
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
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

    private function sendResetEmail($username){
        $emailManager = new EmailManager($username);

        return $emailManager->resetPassword();
    }

    private function sendConfirmEmail($username){
        $emailManager = new EmailManager($username);

        return $emailManager->confirmEmail();
    }
}
