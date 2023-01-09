<?php
/**
 * @var \yii\web\View $this
 * @var array $elements
 * @var string $formName
 * @var array $buttons
 */
?>

<div class="select2-expanded-container" style="margin-top: 5px">

    <div class="expanded-container">
        <?php $i = 0;
        foreach ($elements as $id => $element) : ?>
            <div class="expanded-elements">
                <div class="expanded-control">
                    <a class="expanded-close"><i class="fa fa-close"></i></a>
                    <span class="title"><?= $element['title']; ?></span>
                    <?php if ($element['buttons']): ?>
                        <span class="expanded-buttons">
                    <?php foreach ($element['buttons'] as $button): ?>
                        <?= $button ?>
                    <?php endforeach; ?>
                    </span>
                    <?php endif; ?>
                </div>
                <div class="inputs" style="display: none;">
                    <input class="expanded-element-id" type="hidden" value="<?= $id; ?>"
                           name="<?= $formName; ?>[<?= $i; ?>]"/>
                </div>
            </div>
            <?php $i++; endforeach; ?>
    </div>

    <div class="expanded-elements expanded-template" style="display: none;">
        <div class="expanded-control">
            <a class="expanded-close"><i class="fa fa-close"></i></a>
            <span class="title"></span>
            <span class="expanded-buttons">
                <?php foreach ($buttons as $button): ?>
                    <?= $button ?>
                <?php endforeach; ?>
            </span>
        </div>
        <div class="inputs" style="display: none;">
            <input class="expanded-element-id" type="hidden" name="<?= $formName; ?>[]"/>
        </div>
    </div>

</div>
