<?php
namespace app\models;


use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $first_name;
    public $last_name;
    public $department;
    public $userType;
    public $email;
    public $password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['first_name', 'required'],
            ['last_name', 'required'],
            ['userType', 'required'],
            ['department', 'required'],
            ['username', 'unique', 'targetClass' => 'app\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => 'app\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->first_name = $this->first_name;
            $user->last_name = $this->last_name;
            $user->user_type_id  = $this->userType;
            $user->department_id = $this->department;
            $user->userType  = $this->userType;
            $user->department = $this->department;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $transaction = Yii::$app->db->beginTransaction();
            if ($user->save()) {
                $accData = \app\models\User::calculateSalData($user->id,$this->department,$this->userType);
                $accountsModel = new UserAccounts();
                $accountsModel->user_id = $accData['user_id'];
                $accountsModel->basic_salary = $accData['basic_salary'];
                $accountsModel->payable_salary = $accData['payable_salary'];
                $accountsModel->tax_value = $accData['tax_value'];
                if($accountsModel->save()){
                    $transaction->commit();
                    Yii::$app->session->setFlash('success', 'User updated successfully.');
                    return $user;
                }else{
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', 'Error while saving user data.');
                    return null;
                }
            }
        }

        return null;
    }
}
