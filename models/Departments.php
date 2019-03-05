<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_departments".
 *
 * @property int $id
 * @property string $name
 * @property int $commission
 * @property string $allowance
 * @property int $last_month_deduction
 */
class Departments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'departments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'commission', 'allowance', 'last_month_deduction'], 'required'],
            [['commission', 'last_month_deduction'], 'integer'],
            [['allowance'], 'number'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'commission' => 'Commission',
            'allowance' => 'Allowance',
            'last_month_deduction' => 'Last Month Deduction',
        ];
    }
}
