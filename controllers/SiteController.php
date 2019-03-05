<?php

namespace app\controllers;

/* use Yii;
  use yii\filters\AccessControl;
  use yii\web\Controller;
  use yii\filters\VerbFilter;
  use app\models\LoginForm;
  use app\models\ContactForm; */

use app\models\CsvForm;
use app\models\Departments;
use app\models\Taxcharges;
use app\models\UserTypes;
use Yii;
use app\models\LoginForm;
use app\models\PasswordResetRequestForm;
use app\models\ResetPasswordForm;
use app\models\SignupForm;
use app\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

class SiteController extends Controller {

    public function behaviors() {
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

    public function actions() {
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

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionLogin() {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                        'model' => $model,
            ]);
        }
    }

    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionSignup() {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
                    'model' => $model,
        ]);
    }

    public function actionContact() {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                        'model' => $model,
            ]);
        }
    }

    public function actionAbout() {
        return $this->render('about');
    }

    public function actionRequestPasswordReset() {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
                    'model' => $model,
        ]);
    }

    public function actionResetPassword($token) {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
                    'model' => $model,
        ]);
    }

    public function actionUpload(){
        $model = new CsvForm();

        if($model->load(Yii::$app->request->post())){
            $file = UploadedFile::getInstance($model,'file');
            $filename = 'data'.'.'.$file->extension;

            $saveDirectory = 'uploads/';
            if (!is_dir($saveDirectory)) {
                $old = umask(0);
                mkdir($saveDirectory, 0777, true);
                umask($old);
            }
            $complete_path  = $saveDirectory.$filename;


            if (copy($file->tempName, $complete_path)) {
                define('CSV_PATH','uploads/');
                $csv_file = CSV_PATH . $filename;
                $filecsv = file($csv_file);
                $i = 0;
                foreach($filecsv as $data){
                    $i++;
                    if($i==1) continue;
                    $departments = new Departments();
                    $hasil = explode(",",$data);
                    $departments->name = $hasil[1];
                    $departments->commission = $hasil[2];
                    $departments->allowance = $hasil[3];
                    $departments->last_month_deduction = $hasil[4];
                    $departments->save();
                }
                unlink('uploads/'.$filename);
                return $this->redirect(['site/index']);
            }
        }else{
            return $this->render('upload',['model'=>$model]);
        }
    }


    public function actionUploadUserAccounts(){
        $model = new CsvForm();

        if($model->load(Yii::$app->request->post())){
            $file = UploadedFile::getInstance($model,'file');
            $filename = 'data'.'.'.$file->extension;

            $saveDirectory = 'uploads/';
            if (!is_dir($saveDirectory)) {
                $old = umask(0);
                mkdir($saveDirectory, 0777, true);
                umask($old);
            }
            $complete_path  = $saveDirectory.$filename;


            if (copy($file->tempName, $complete_path)) {
                define('CSV_PATH','uploads/');
                $csv_file = CSV_PATH . $filename;
                $filecsv = file($csv_file);
                $i = 0;
                foreach($filecsv as $data){
                    $i++;
                    if($i==1) continue;
                    $userTypes = new UserTypes();
                    $hasil = explode(",",$data);
                    $userTypes->name = $hasil[1];
                    $userTypes->basic_salary = $hasil[2];
                    $userTypes->save();
                }
                unlink('uploads/'.$filename);
                return $this->redirect(['site/index']);
            }
        }else{
            return $this->render('upload',['model'=>$model]);
        }
    }

    public function actionUploadTaxCharges(){
        $model = new CsvForm();

        if($model->load(Yii::$app->request->post())){
            $file = UploadedFile::getInstance($model,'file');
            $filename = 'data'.'.'.$file->extension;

            $saveDirectory = 'uploads/';
            if (!is_dir($saveDirectory)) {
                $old = umask(0);
                mkdir($saveDirectory, 0777, true);
                umask($old);
            }
            $complete_path  = $saveDirectory.$filename;

            if (copy($file->tempName, $complete_path)) {
                define('CSV_PATH','uploads/');
                $csv_file = CSV_PATH . $filename;
                $filecsv = file($csv_file);
                $i = 0;
                foreach($filecsv as $data){
                    $i++;
                    if($i==1) continue;
                    $taxCharges = new Taxcharges();
                    $hasil = explode(",",$data);
                    $taxCharges->salary_upto = $hasil[1];
                    $taxCharges->tax_percentage = $hasil[2];
                    $taxCharges->save();
                }
                unlink('uploads/'.$filename);
                return $this->redirect(['site/index']);
            }
        }else{
            return $this->render('upload',['model'=>$model]);
        }
    }

}
