<?php

use common\modules\publication\models\Publication;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\modules\publication\models\search\PublicationSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Publications';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="publication-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Publication', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title',
            'category_id',
            'sub_category_id',
            'price',
            //'description:ntext',
            //'location',
            //'latitude',
            //'longitude',
            //'tariff_id',
            //'is_mutually_surcharged',
            //'is_active',
            //'user_id',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Publication $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
