<?php

/**
 * @var \app\core\entities\Shop\Brand[] $brands
 */
\app\widgets\assets\FilterPublicAsset::register($this);
?>

<div class="filter filter--closed">
    <form id="filter-aside" class="filter__form" method="post"
          action="<?= \yii\helpers\Url::to(['/catalog/category', 'slug' => 'pryazha']) ?>">
        <a class="filter__selected">Показать <b>256</b> позиций</a>
        <fieldset class="filter__group">
            <legend class="filter__group-title">По составу</legend>
            <label><input type="checkbox" name="filter-type" checked><span
                        class="filter__item-span"></span>Пряжа классическая однотонной
                окраски</label><br>
            <label><input type="checkbox" name="filter-type"><span class="filter__item-span"></span>Пряжа
                классическая фантазийной окраски</label><br>
            <label><input type="checkbox" name="filter-type"><span class="filter__item-span"></span>Пряжа
                фасонная однотонной окраски</label><br>
            <label><input type="checkbox" name="filter-type"><span class="filter__item-span"></span>Пряжа
                фасонная фантазийной окраски</label><br>
            <label><input type="checkbox" name="filter-type"><span class="filter__item-span"></span>Пряжа
                пушистая (мохеры, акрилы и пр.) однотонной окраски</label><br>
            <label><input type="checkbox" name="filter-type"><span class="filter__item-span"></span>Пряжа
                пушистая (мохеры, акрилы и пр.) фантазийная окраска</label><br>
            <label><input type="checkbox" name="filter-type"><span class="filter__item-span"></span>Пряжа,
                на основе хлопка, вискозы, бамбука</label>
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
