<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model common\modules\category\models\search\CategorySearch */
?>

<div class="event-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
            </div>

            <div class="col-md-6">
                <?= $form->field($model, 'is_active')->dropDownList([
                    '' => 'Все',
                    '1' => 'Активные',
                    '0' => 'Неактивные',
                ]); ?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary btn-block']) ?>
            </div>
            <div class="col-md-6">
                <?= Html::a('Сбросить фильтр', ['index'], ['class' => 'btn btn-default btn-block']); ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
