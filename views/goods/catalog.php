<?php
use yii\widgets\ListView;
?>

<div class="filter__button-wrapper">
    <button class="filter__button filter__button--closed">Фильтр <span class="filter__arrow"></span></button>
</div>
<section class="main__content">
    <aside class="main__left-column">
        <?php echo \app\widgets\Categories::widget() ?>


        <div class="filter filter--closed">
            <form class="filter__form" method="post" action="">
                <a class="filter__selected">Показать <b>256</b> позиций</a>
                <fieldset class="filter__group">
                    <legend class="filter__group-title">Тип пряжи</legend>
                    <label><input type="checkbox" name="filter-type" checked><span class="filter__item-span"></span>Пряжа классическая однотонной окраски</label><br>
                    <label><input type="checkbox" name="filter-type"><span class="filter__item-span"></span>Пряжа классическая фантазийной окраски</label><br>
                    <label><input type="checkbox" name="filter-type"><span class="filter__item-span"></span>Пряжа фасонная однотонной окраски</label><br>
                    <label><input type="checkbox" name="filter-type"><span class="filter__item-span"></span>Пряжа фасонная фантазийной окраски</label><br>
                    <label><input type="checkbox" name="filter-type"><span class="filter__item-span"></span>Пряжа пушистая (мохеры, акрилы и пр.) однотонной окраски</label><br>
                    <label><input type="checkbox" name="filter-type"><span class="filter__item-span"></span>Пряжа пушистая (мохеры, акрилы и пр.) фантазийная окраска</label><br>
                    <label><input type="checkbox" name="filter-type"><span class="filter__item-span"></span>Пряжа, на основе хлопка, вискозы, бамбука</label>
                </fieldset>
                <fieldset class="filter__group">
                    <legend class="filter__group-title">Торговые марки</legend>
                    <label><input type="checkbox" name="filter-manufacturer"><span class="filter__item-span"></span>Adelia</label><br>
                    <label><input type="checkbox" name="filter-manufacturer" checked><span class="filter__item-span"></span>Alize</label><br>
                    <label><input type="checkbox" name="filter-manufacturer"><span class="filter__item-span"></span>Alpina</label><br>
                    <label><input type="checkbox" name="filter-manufacturer"><span class="filter__item-span"></span>CANAN</label><br>
                    <label><input type="checkbox" name="filter-manufacturer"><span class="filter__item-span"></span>CHEVAL BLANC</label><br>
                    <label><input type="checkbox" name="filter-manufacturer"><span class="filter__item-span"></span>Color City</label><br>
                    <label><input type="checkbox" name="filter-manufacturer"><span class="filter__item-span"></span>HOOOKED</label>
                </fieldset>
            </form>
        </div>
    </aside>
    <div class="main__page-content">

        <div class="catalog">
            <h1 class="catalog__title">Каталог товаров</h1>
            <p class="catalog__descr">В каталоге представленна различная пряжа, а также сопутствующие товары для вязания</p>
                <?= ListView::widget([
                        'dataProvider' => $dataProvider,
                        'itemView' => 'block/_categoryItem',
                        'itemOptions' => ['class' => 'catalog__item product'],
                        'options' => ['class' => 'catalog__list'],

                ]) ?>
        </div>

    </div>
</section>
