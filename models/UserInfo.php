<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "userinfo".
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property int $payable_salary
 * @property int $basic_salary
 * @property double $tax_value
 * @property int $last_month_deduction
 * @property string $department_name
 * @property string $employee_type_name
 */
class Userinfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'userinfo';
    }

    /**
     * primary key for user info view model
     * @return array|string[]
     */
    public static function primaryKey()
    {
        return ['id'];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'payable_salary', 'basic_salary', 'last_month_deduction'], 'integer'],
            [['first_name', 'last_name', 'payable_salary', 'basic_salary', 'tax_value', 'last_month_deduction', 'department_name', 'employee_type_name'], 'required'],
            [['tax_value'], 'number'],
            [['first_name', 'last_name', 'employee_type_name'], 'string', 'max' => 50],
            [['department_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'payable_salary' => 'Payable Salary',
            'basic_salary' => 'Basic Salary',
            'tax_value' => 'Tax Value',
            'last_month_deduction' => 'Last Month Deduction',
            'department_name' => 'Department Name',
            'employee_type_name' => 'Employee Type Name',
        ];
    }
}
