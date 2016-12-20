<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 19.12.16
 * Time: 15:39
 */
namespace app\controllers;

use app\models\EditUserForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use app\models\User;

class UserController extends Controller
{
    protected $userGroup = 'USER';

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
     * Displays user's homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $user = Yii::$app->user->identity;
        $users = User::find()->all();

        return $this->render('index', ['user' => $user, 'users' => $users]);
    }

    /**
     * Displays user's cabinet.
     *
     * @return string
     */
    public function actionCabinet()
    {
        $user = Yii::$app->user->identity;
        $userId = $user->getId();

        return $this->render('cabinet', ['user' => $user]);
    }

    /**
     * Displays edit page.
     *
     * @return string
     */
    public function actionEdit()
    {
        $user = Yii::$app->user->identity;

        $model = new EditUserForm($user);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user->edit($model);

            return $this->goHome();
        }

        return $this->render('edit', ['user' => $user, 'model' => $model]);
    }


    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            if (\Yii::$app->user->identity->group != $this->userGroup) {
                throw new ForbiddenHttpException('Access denied');
            }
            return true;
        } else {
            return false;
        }
    }
}