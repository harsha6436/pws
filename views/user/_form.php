<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'first_name')->textInput() ?>
    <?= $form->field($model, 'last_name')->textInput() ?>
    <?php

        $model->department = !empty($model->userDepartment->id)?$model->userDepartment->id:'';
        $model->userType = !empty($model->userTypeData->id)?$model->userTypeData->id:'';
    ?>
    <?= $form->field($model, 'department')
        ->dropDownList(
            \yii\helpers\ArrayHelper::map(\app\models\Departments::find()->asArray()->all(), 'id', 'name')
        ) ?>

    <?= $form->field($model, 'userType')
        ->dropDownList(
            \yii\helpers\ArrayHelper::map(\app\models\UserTypes::find()->asArray()->all(), 'id', 'name')
        ) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
