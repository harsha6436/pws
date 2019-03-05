<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_accounts".
 *
 * @property int $id
 * @property int $user_id
 * @property int $payable_salary
 * @property int $basic_salary
 * @property double $tax_value
 */
class UserAccounts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_accounts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'payable_salary', 'basic_salary', 'tax_value'], 'required'],
            [['user_id', 'payable_salary', 'basic_salary'], 'integer'],
            [['tax_value'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'payable_salary' => 'Payable Salary',
            'basic_salary' => 'Basic Salary',
            'tax_value' => 'Tax Value',
        ];
    }
}
