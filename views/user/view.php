<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">
    <p><?php $this->title = 'View User'?></p>
    <p>
        <?= Html::a('Users', ['index'], ['class' => 'btn btn-primary float-right']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'first_name',
            'last_name',
            'email:email',
            [
                'attribute' => 'userType',
                'format' => 'raw',
                'header' => 'User Type',
                'headerOptions' => ['class' => 'theadcolor'],
                'value' => function ($model) {
                    return $model->userTypeData->name;
                }
            ],
            [
                'attribute' => 'department_id',
                'format' => 'raw',
                'header' => 'Department',
                'headerOptions' => ['class' => 'theadcolor'],
                'value' => function ($model) {
                    return $model->userDepartment->name;
                }
            ],
        ],
    ]) ?>

</div>
