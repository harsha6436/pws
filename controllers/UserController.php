<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $data = Yii::$app->request->post();
            $model->department_id  = $data['User']['department'];
            $model->user_type_id  = $data['User']['userType'];
            $transaction = Yii::$app->db->beginTransaction();
            if($model->save()){
                $accData = User::calculateSalData($model->id,$model->department,$model->userType);

                $result = \Yii::$app->db->createCommand("CALL update_accounts(:uid, :psal, :bsal, :tval)")
                    ->bindValue(':uid' , $accData['user_id'] )
                    ->bindValue(':psal', $accData['payable_salary'])
                    ->bindValue(':bsal', $accData['basic_salary'])
                    ->bindValue(':tval', $accData['tax_value'])
                    ->execute();
                if($result){
                    $transaction->commit();
                    Yii::$app->session->setFlash('success', 'User updated successfully.');
                    return $this->redirect(['view', 'id' => $model->id]);
                }else{
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', 'Error while saving user data.');
                    return $this->render('update', [
                        'model' => $model,
                    ]);
                }
            }else{
                return $this->render('update', [
                    'model' => $model,
                ]);
            }

        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
