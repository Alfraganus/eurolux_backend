<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;

/* @var $title string */
/* @var $buttonText string */
/* @var $this yii\web\View */
/* @var $imageHeight integer */
/* @var $textAttribute string */
/* @var $createUrl string */
/* @var $updateUrl string */
/* @var $deleteUrl string */
/* @var $btnClass string */
/* @var $btnWidth string */
/* @var $imageColumnSize integer */
/* @var $formCreateActionUrl \yii\helpers\Url */
/* @var $images \chulakov\filestorage\models\Image */

?>
<div class="ocs-widget-images-container">
    <div class="widget-images ocs-widget-images clearfix"
         data-confirm_delete_text="<?= Yii::t('OlegChulakovStudio/widgets/image/index', 'Вы действительно хотите удалить выбранный элемент?'); ?>"
         data-create-url="<?= $createUrl ?>"
         data-update-url="<?= $updateUrl ?>"
         data-delete-url="<?= $deleteUrl ?>"
         <?php if ($textAttribute): ?>data-text-attribute="<?= $textAttribute ?>"<?php endif; ?>
         <?php if ($imageColumnSize): ?>data-image-column-size="<?= $imageColumnSize ?>"<?php endif; ?>
         <?php if ($imageHeight): ?>data-image-height="<?= $imageHeight; ?>"><?php endif; ?>
        <?php if (!empty($models)): ?>
            <?php foreach ($models as $model): ?>
                <div class="col-md-<?= $imageColumnSize ?> image-item-container">
                    <div class="thumbnail image-item">
                        <div class="item">
                            <div class="img">
                                <?=
                                Html::img($model->image ? $model->{$imageAttribute}->contain(300, 300) : '', [
                                    'class' => 'img-responsive',
                                    'style' => "height:{$imageHeight}px;",
                                    'data-id' => $model->id
                                ]);
                                ?>
                            </div>
                            <div class="item-content"><i class="glyphicon glyphicon-pencil"></i></div>
                        </div>
                        <span class="caption"><?php if ($textAttribute): ?><?= $model->{$textAttribute} ?><?php endif; ?></span>
                        <?=
                        Html::button('<i class="glyphicon glyphicon-trash"></i>', [
                                'class' => 'btn btn-danger btn-block delete-image'
                            ]
                        );
                        ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <?php

    Modal::begin([
        'headerOptions' => ['class' => 'text-center'],
        'header' => '<h2>' . Yii::t('OlegChulakovStudio/widgets/image/index', $title) . '</h2>',
        'class' => 'ocs-widget-images-modal',
        'id' => 'ocs-widget-images-modal' . time() . rand(0, 200),
        'size' => 'modal-lg',
        'toggleButton' => [
            'label' => Yii::t('OlegChulakovStudio/widgets/image/index', $buttonText),
            'class' => "{$btnClass} widget-image-btn-add",
            'style' => "width:{$btnWidth}%",
            'id' => 'widget-image-btn-add' . time() . rand(0, 200),
            'data-form-action' => $createUrl
        ],
        'options' => ['style' => 'min-width:400px']
    ]);
    Modal::end();
    ?>

</div>
