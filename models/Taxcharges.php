<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "taxcharges".
 *
 * @property int $id
 * @property int $salary_upto
 * @property string $tax_percentage
 */
class Taxcharges extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'taxcharges';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['salary_upto', 'tax_percentage'], 'required'],
            [['salary_upto'], 'integer'],
            [['tax_percentage'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'salary_upto' => 'Salary Upto',
            'tax_percentage' => 'Tax Percentage',
        ];
    }
}
