<?php

use common\modules\category\models\Category;
use common\modules\category\services\CategoryService;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\category\models\search\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категории';

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
            <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <div class="box-body">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'id',
                [
                    'label' => 'Иконка',
                    'format' => 'raw',
                    'contentOptions' => ['style' => 'width:120px'],
                    'value' => function ($model) {
                        if ($model->image) {
                            return Html::img($model->image->asset_path , [
                                'style' => 'width:60px',
                                'class' => 'profile-user-img img-responsive'
                            ]);
                        }
                    }
                ],
                'title',
                'description',
                [
                    'attribute' => 'is_active',
                    'format' => 'raw',
                    'value' => function (Category $model) {
                        return \common\widgets\toggle\ToggleInputWidget::widget([
                            'model' => $model,
                            'attribute' => 'is_active',
                            'updateRoute' => ['active', 'id' => $model->id]
                        ]);
                    }
                ],
                [
                    'class' => ActionColumn::class,
                    'template' => '{update} {sub-category} {delete}',
                    'buttons' => [
                        'sub-category' => function ($url, Category $model) {
                            return Html::a('<span class="glyphicon glyphicon-list"></span>', ['/category/sub-category', 'category_id' => $model->id], [
                                'title' => 'Подкатегории',
                                'data-pjax' => 0
                            ]);
                        },
                    ]
                ]
            ]
        ]); ?>
    </div>
</div>