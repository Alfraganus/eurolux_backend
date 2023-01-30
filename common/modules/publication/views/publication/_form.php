<?php

use common\modules\category\services\CategoryService;
use kartik\depdrop\DepDrop;
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\modules\publication\models\Publication $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="publication-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'category_id')->dropDownList(\sem\helpers\ArrayHelper::map(
                    \common\modules\category\models\Category::find()->all(),'id','title'),
              [
                'prompt'=>'Select Category',
                'id'=>'category_id',
            ]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'sub_category_id')->widget(DepDrop::classname(), [
                'options'=>['id'=>'subcategory_id'],
                'pluginOptions'=>[
                    'depends'=>['category_id'],
                    'placeholder'=>'Select Subcategory',
                    'url'=>Url::to(['find-sub-category']),
                    'value' => 'title',
                    'label' => 'title',
                ]
            ]); ?>
        </div>


        <div class="col-md-6">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'price')->textInput() ?>
        </div>


        <div class="col-md-6">
            <?= $form->field($model, 'is_active')->dropDownList([
                    10=>'Active',
                     0=>'InActive'
            ]) ?>
        </div>

        <?= $form->field($model, 'images[]')->widget(FileInput::class, [
            'options' => ['multiple' => true],
            'pluginOptions' => [
//                'initialPreview' => isset($model->model->image) ? CategoryService::getImagePath($model):[],
//                'initialPreviewAsData' => true,
//                'initialPreviewDownloadUrl' =>isset($model->model->image) ? CategoryService::getImagePath($model):[],
                'showUpload' => false,
                'overwriteInitial' => true,
                'showRemove' => false,
                'showClose' => false,
                'fileActionSettings' => [
                    'showRemove' => false
                ],
            ],
        ]); ?>

    </div>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
