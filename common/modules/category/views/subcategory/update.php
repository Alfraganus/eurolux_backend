<?php

/* @var $this yii\web\View */
/* @var $model common\modules\category\models\Category */

$this->title = 'Редактирование подкатегории';

$this->params['breadcrumbs'][] = 'Категории';
$this->params['breadcrumbs'][] = ['label' => 'Податегории', 'url' => ['/category/sub-category/index']];
$this->params['breadcrumbs'][] = $this->title;

use yii\helpers\Html; ?>

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