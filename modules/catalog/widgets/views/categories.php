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
            <a class="link aside-catalog__link <?= strpos(Yii::$app->request->url,
                $category->slug) !== false ? 'aside-catalog__link--active' : '' ?>"
               href="<?= Url::to(['/catalog/default/category', 'slug' => $category->slug]) ?>"><?= $category->name ?>
                <? /*= $category->countGoods */ ?></a>
        <?php endforeach; ?>
    </div>
</div>