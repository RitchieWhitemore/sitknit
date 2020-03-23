<?php

/**
 * @var \app\core\entities\Shop\Brand[] $brands
 * @var \app\core\entities\Shop\Composition[] $compositions
 */

use app\modules\catalog\widgets\assets\FilterPublicAsset;

FilterPublicAsset::register($this);

?>

<div class="filter filter--closed">
    <form id="filter-aside" class="filter__form" method="post"
          action="<?= \yii\helpers\Url::to(['/catalog/default/category', 'slug' => 'pryazha']) ?>">
        <a class="filter__selected">Показать <b>256</b> позиций</a>
        <fieldset class="filter__group">
            <legend class="filter__group-title">По составу</legend>
            <?php foreach ($compositions as $composition) : ?>
                <label><input type="checkbox" name="GoodFilterSearch[compositionIds][]" value="<?= $composition->id ?>"><span
                        class="filter__item-span"></span><?= $composition->name ?></label>
            <?php endforeach; ?>
        </fieldset>
        <fieldset class="filter__group">
            <legend class="filter__group-title">Торговые марки</legend>
            <?php foreach ($brands as $brand) : ?>
                <label><input type="checkbox" name="GoodFilterSearch[brandIds][]" value="<?= $brand->id ?>"><span
                            class="filter__item-span"></span><?= $brand->name ?></label>
            <?php endforeach; ?>
        </fieldset>
    </form>
</div>
