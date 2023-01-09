<?php

use common\modules\category\services\CategoryService;
use common\widgets\input2slug\SlugInput;
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model common\modules\category\models\Category */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'title')->widget(SlugInput::class, [
                'targetId' => 'category-slug',
                'options' => [
                    'maxlength' => true,
                    'class' => 'form-control',
                ]
            ]); ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'slug')->textInput(['maxlength' => true, 'id' => 'category-slug']); ?>
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

    <?= $form->field($model, 'iconFile')->widget(FileInput::class, [
        'pluginOptions' => [
            'initialPreview' => isset($model->model->image) ? CategoryService::getImagePath($model):[],
            'initialPreviewAsData' => true,
            'initialPreviewDownloadUrl' =>isset($model->model->image) ? CategoryService::getImagePath($model):[],
            'showUpload' => false,
            'overwriteInitial' => true,
            'showRemove' => false,
            'showClose' => false,
            'fileActionSettings' => [
                'showRemove' => false
            ],
        ],
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success btn-block']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>