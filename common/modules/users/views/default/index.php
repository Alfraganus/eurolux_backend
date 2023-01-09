<?php
/**
 * Шаблон списка пользователей
 *
 * @var $this yii\web\View
 * @var $searchModel UsersSearch
 * @var $dataProvider \yii\data\ActiveDataProvider
 */

use common\modules\users\models\search\UsersSearch;
use sem\helpers\Html;
use yii\grid\GridView;

$this->title = 'Список пользователей';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?=$this->title?></h3>

        <div class="box-tools pull-right">
            <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
                <i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="box-body">
        <?= GridView::widget([
            'filterModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'columns' => [
                [
                    'attribute' => 'id',
                    'headerOptions' => ['width' => 100],
                ],
                'name',
                'phone',
                'is_active:boolean',

                [
                    'class' => \andrewdanilov\gridtools\FontawesomeActionColumn::class,
                    'template' => '{update}{delete}',
                ]
            ]
        ]) ?>
    </div>
</div>
