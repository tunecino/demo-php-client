<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\SearchForm;

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
            'ajaxFilter' => [
                'class' => 'yii\filters\AjaxFilter',
                'only' => ['load-next']
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
        $form = new SearchForm();
        $api = Yii::$app->beachinsoft;
        $form->load(Yii::$app->request->post());

        return $this->render('index', [
            'form' => $form,
            'postProvider' => $api->getData($form->query)
        ]);
    }

    /**
     * Load next set of data.
     *
     * @return string
     */
    public function actionLoadNext($keywords = '', $page = 1)
    {
        $api = Yii::$app->beachinsoft;
        $data = $api->getData($keywords, $page);
        $htmlTemplate = '';
        /**
         * A manual rebuild of the template to avoid using Pjax
         * as Pjax is expected to be deprecated in the next release and there
         * are no official alternatives: https://github.com/yiisoft/yii2/issues/15383
         */
        foreach ($data->allModels as $k => $item) {
            $htmlTemplate .=  '<div data-key="' . ($page * $api->limit + $k) . '">';
            $htmlTemplate .=  $this->renderAjax('_post', ['model' => $item]);
            $htmlTemplate .=  '</div>';
        }
        return $htmlTemplate;
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
     * Displays contact page.
     *
     * @return Response|string
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
}
