<?php
/* @var $this yii\web\View */
/* @var $model common\modules\category\models\SubCategory */

$this->title = 'Новая подкатегория';

$this->params['breadcrumbs'][] = 'Категории';
$this->params['breadcrumbs'][] = ['label' => 'Податегории', 'url' => ['/category/sub-category/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?= $this->title ?></h3>

    </div>
    <div class="box-body">
        <?= $this->render('_form', [
            'model' => $model
        ]); ?>
    </div>
</div>