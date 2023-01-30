<?php

use andrewdanilov\adminpanel\widgets\Menu;

/* @var $this \yii\web\View */
/* @var $siteName string */
/* @var $directoryAsset false|string */

?>

<div class="page-left">
	<div class="sidebar-heading"><?= 'T_T_Exchange' ?></div>
	<?= Menu::widget(['items' => [
		['label' => 'Dashboard', 'url' => ['/site/index'], 'icon' => 'desktop'],
		[],
		['label' => 'Разделы приложения'],
		['label' => 'Публикации', 'url' => ['/publication/publication/index'], 'icon' => ['symbol' => 'newspaper', 'type' => 'regular']],
		['label' => 'Пользователи', 'url' => ['/users/default/index'], 'icon' => ['symbol' => 'newspaper', 'type' => 'solid']],
		['label' => 'Категории', 'url' => ['/category/category/index'], 'icon' => ['symbol' => 'newspaper', 'type' => 'solid']],
		[],
		['label' => 'Техподдержка'],
		['label' => 'Users', 'url' => ['/user/index'], 'icon' => 'users'],
	]]) ?>
</div>
