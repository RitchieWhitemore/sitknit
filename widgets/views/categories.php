<?php

use yii\helpers\Url;

/**
 *
 * @var $categories app\core\entities\Shop\Category
 * */
?>

<div class="aside-catalog">
    <h2 class="aside-catalog__title">Каталог</h2>
    <div class="aside-catalog__list">
        <?php foreach ($categories as $category) : ?>
            <a class="link aside-catalog__link <?= isset($activeCategory) && $category->id == $activeCategory->id ? 'aside-catalog__link--active': ''?>"
               href="<?= Url::to(['/catalog/category', 'id' => $category->id]) ?>"><?= $category->name ?>
                (<?= $category->countGoods ?>)</a>
        <?php endforeach; ?>
    </div>
</div>