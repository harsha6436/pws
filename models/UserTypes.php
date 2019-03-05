<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_types".
 *
 * @property int $id
 * @property string $name
 * @property int $basic_salary
 */
class UserTypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'basic_salary'], 'required'],
            [['basic_salary'], 'integer'],
            [['name'], 'string', 'max' => 50],
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
            'basic_salary' => 'Basic Salary',
        ];
    }
}
