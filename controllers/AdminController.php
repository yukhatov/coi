<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 19.12.16
 * Time: 15:39
 */
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use app\models\User;
use app\models\EditUserForm;

class AdminController extends Controller
{
    protected $userGroup = 'ADMIN';

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
     * Displays admin's homepage.
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
     * Displays edit page.
     *
     * @return string
     */
    public function actionEdituser($id)
    {
        $userForEdit = User::findOne($id);
        $user = Yii::$app->user->identity;

        if($userForEdit){
            $model = new EditUserForm($userForEdit);

            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                $userForEdit->edit($model);

                return $this->goHome();
            }

            return $this->render('edit', ['user' => $user, 'model' => $model]);
        }else{
            return $this->goHome();
        }
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