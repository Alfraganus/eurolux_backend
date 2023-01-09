<?php

use common\modules\category\models\SubCategory;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\category\models\search\SubCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $category common\modules\category\models\Category */

$this->title = 'Подкатегории';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-default collapsed-box">
    <div class="box-header with-border">
        <h3 class="box-title">Фильтр</h3>
    </div>
    <div class="box-body">
        <?= $this->render('_search', ['model' => $searchModel]) ?>
    </div>
</div>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?= $this->title; ?></h3>

        <div class="box-tools pull-right">
            <?= Html::a('Добавить', ['create', 'category_id' => $category->id], ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <div class="box-body">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'id',
                'title',
                'description',
                [
                    'attribute' => 'is_active',
                    'format' => 'raw',
                    'value' => function (SubCategory $model) {
                        return \common\widgets\toggle\ToggleInputWidget::widget([
                            'model' => $model,
                            'attribute' => 'is_active',
                            'updateRoute' => ['active', 'id' => $model->id]
                        ]);
                    }
                ],
                [
                    'class' => ActionColumn::class,
                    'template' => '{update} {delete}',
                ]
            ]
        ]); ?>
    </div>
</div>