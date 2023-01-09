<?php

use common\widgets\input2slug\SlugInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model common\modules\category\models\SubCategory */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'title')->widget(SlugInput::class, [
                'targetId' => 'sub-category-slug',
                'options' => [
                    'maxlength' => true,
                    'class' => 'form-control',
                ]
            ]); ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'slug')->textInput(['maxlength' => true, 'id' => 'sub-category-slug']); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'is_active')->checkbox() ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success btn-block']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>