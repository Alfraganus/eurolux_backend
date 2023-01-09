<?php
/**
 * Шаьлон формы редактирования
 *
 * @var $this yii\web\View
 * @var $model common\modules\users\models\forms\UsersForm
*/


$this->title = 'Редактирование';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Редактирование пользователя</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
                <i class="fa fa-minus"></i></button>
        </div>
    </div>
    <div class="box-body">
        <?= $this->render('_form', [
            'model' => $model
        ]); ?>
    </div>
</div>