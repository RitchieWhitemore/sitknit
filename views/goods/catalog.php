<?php
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

        <ul class="breadcrumb">
            <li><a href="/"><i class="fa fa-home"></i></a> /</li>
            <li><a href="">Пряжа</a> /</li>
            <li>Акриловая пряжа</li>
        </ul>

        <div class="control">
            <label class="control__label"> Показать по
                <select class="control__dropdown">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15" selected>15</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </label>

            <!--<div class="control__dropdown-wrapper">
                <button type="button" class="control__dropdown control__dropdown--opened">
                    <span class="control__dropdown-label">Показывать по</span>
                    <span class="control__dropdown-content">15</span>
                    <span class="control__dropdown-icon"></span>
                </button>
                <ul class="control__dropdown-list">
                    <li class="control__dropdown-item">5</li>
                    <li class="control__dropdown-item">10</li>
                    <li class="control__dropdown-item control__dropdown-item--active">15</li>
                    <li class="control__dropdown-item">25</li>
                    <li class="control__dropdown-item">50</li>
                    <li class="control__dropdown-item">100</li>
                </ul>
            </div> -->
        </div>
        <div class="catalog">
            <h1 class="catalog__title">Акриловая пряжа</h1>
            <p class="catalog__descr">Описание акриловой пряжи</p>
            <div class="catalog__list">
                <div class="catalog__item product product--stock">
                    <h2 class="product__title"><a href="#" class="link">Пряжа KLANGWELTEN</a></h2>
                    <span class="product__manufacturer">Opal</span>
                    <div class="product__image-wrapper">
                        <img src="img/yarn-small-1.png" width="144" height="74">
                    </div>
                    <span class="product__color">Зелено-коричневый (9045)</span>
                    <ul class="product__characteristic-list">
                        <li class="product__characteristics-item"><b>Состав:</b> 75% шерсть суперуош 25% полиамид</li>
                        <li class="product__characteristics-item"><b>Вес:</b> 100 гр.</li>
                        <li class="product__characteristics-item"><b>Длина:</b> 425 м.</li>
                    </ul>
                    <div class="product__price-wrapper">
                        <span class="product__price">580 руб.</span>
                        <span class="product__price-old">620 руб.</span>
                    </div>
                </div>
                <div class="catalog__item product product--new">
                    <h2 class="product__title"><a href="#" class="link">Пряжа BABY SET MARIFETLI</a></h2>
                    <span class="product__manufacturer">Alize</span>
                    <div class="product__image-wrapper">
                        <img src="img/yarn-small-2.png" width="90" height="88">
                    </div>
                    <span class="product__color">Розовый (185)</span>
                    <ul class="product__characteristic-list">
                        <li class="product__characteristics-item"><b>Состав:</b>100% полиэстер</li>
                        <li class="product__characteristics-item"><b>Вес:</b>100 гр.</li>
                        <li class="product__characteristics-item"><b>Длина:</b>95 м.</li>
                    </ul>
                    <div class="product__price-wrapper">
                        <span class="product__price">151 руб.</span>
                    </div>
                </div>
                <div class="catalog__item product">
                    <h2 class="product__title"><a href="#" class="link">Пряжа COUNTRY NEW</a></h2>
                    <span class="product__manufacturer">Alize</span>
                    <div class="product__image-wrapper">
                        <img src="img/yarn-small-3.png" width="154" height="79">
                    </div>
                    <span class="product__color">Дикая роза (5293)</span>
                    <ul class="product__characteristic-list">
                        <li class="product__characteristics-item"><b>Состав:</b>100% полиэстер</li>
                        <li class="product__characteristics-item"><b>Вес:</b>100 гр.</li>
                        <li class="product__characteristics-item"><b>Длина:</b>95 м.</li>
                    </ul>
                    <div class="product__price-wrapper">
                        <span class="product__price">175.50 руб.</span>
                    </div>
                </div>
                <div class="catalog__item product product--stock">
                    <h2 class="product__title"><a href="#" class="link">Пряжа KLANGWELTEN</a></h2>
                    <span class="product__manufacturer">Opal</span>
                    <img src="img/yarn-small-1.png" width="144" height="74">
                    <span class="product__color">Зелено-коричневый (9045)</span>
                    <ul class="product__characteristic-list">
                        <li class="product__characteristics-item"><b>Состав:</b> 75% шерсть суперуош 25% полиамид</li>
                        <li class="product__characteristics-item"><b>Вес:</b> 100 гр.</li>
                        <li class="product__characteristics-item"><b>Длина:</b> 425 м.</li>
                    </ul>
                    <div class="product__price-wrapper">
                        <span class="product__price">580 руб.</span>
                        <span class="product__price-old">620 руб.</span>
                    </div>
                </div>
                <div class="catalog__item product product--new">
                    <h2 class="product__title"><a href="#" class="link">Пряжа BABY SET MARIFETLI</a></h2>
                    <span class="product__manufacturer">Alize</span>
                    <img src="img/yarn-small-2.png" width="90" height="88">
                    <span class="product__color">Розовый (185)</span>
                    <ul class="product__characteristic-list">
                        <li class="product__characteristics-item"><b>Состав:</b>100% полиэстер</li>
                        <li class="product__characteristics-item"><b>Вес:</b>100 гр.</li>
                        <li class="product__characteristics-item"><b>Длина:</b>95 м.</li>
                    </ul>
                    <div class="product__price-wrapper">
                        <span class="product__price">151 руб.</span>
                    </div>
                </div>
                <div class="catalog__item product">
                    <h2 class="product__title"><a href="#" class="link">Пряжа COUNTRY NEW</a></h2>
                    <span class="product__manufacturer">Alize</span>
                    <img src="img/yarn-small-3.png" width="154" height="79">
                    <span class="product__color">Дикая роза (5293)</span>
                    <ul class="product__characteristic-list">
                        <li class="product__characteristics-item"><b>Состав:</b>100% полиэстер</li>
                        <li class="product__characteristics-item"><b>Вес:</b>100 гр.</li>
                        <li class="product__characteristics-item"><b>Длина:</b>95 м.</li>
                    </ul>
                    <div class="product__price-wrapper">
                        <span class="product__price">175.50 руб.</span>
                    </div>
                </div>
                <div class="catalog__item product product--stock">
                    <h2 class="product__title"><a href="#" class="link">Пряжа KLANGWELTEN</a></h2>
                    <span class="product__manufacturer">Opal</span>
                    <img src="img/yarn-small-1.png" width="144" height="74">
                    <span class="product__color">Зелено-коричневый (9045)</span>
                    <ul class="product__characteristic-list">
                        <li class="product__characteristics-item"><b>Состав:</b> 75% шерсть суперуош 25% полиамид</li>
                        <li class="product__characteristics-item"><b>Вес:</b> 100 гр.</li>
                        <li class="product__characteristics-item"><b>Длина:</b> 425 м.</li>
                    </ul>
                    <div class="product__price-wrapper">
                        <span class="product__price">580 руб.</span>
                        <span class="product__price-old">620 руб.</span>
                    </div>
                </div>
                <div class="catalog__item product product--new">
                    <h2 class="product__title"><a href="#" class="link">Пряжа BABY SET MARIFETLI</a></h2>
                    <span class="product__manufacturer">Alize</span>
                    <img src="img/yarn-small-2.png" width="90" height="88">
                    <span class="product__color">Розовый (185)</span>
                    <ul class="product__characteristic-list">
                        <li class="product__characteristics-item"><b>Состав:</b>100% полиэстер</li>
                        <li class="product__characteristics-item"><b>Вес:</b>100 гр.</li>
                        <li class="product__characteristics-item"><b>Длина:</b>95 м.</li>
                    </ul>
                    <div class="product__price-wrapper">
                        <span class="product__price">151 руб.</span>
                    </div>
                </div>
                <div class="catalog__item product">
                    <h2 class="product__title"><a href="#" class="link">Пряжа COUNTRY NEW</a></h2>
                    <span class="product__manufacturer">Alize</span>
                    <img src="img/yarn-small-3.png" width="154" height="79">
                    <span class="product__color">Дикая роза (5293)</span>
                    <ul class="product__characteristic-list">
                        <li class="product__characteristics-item"><b>Состав:</b>100% полиэстер</li>
                        <li class="product__characteristics-item"><b>Вес:</b>100 гр.</li>
                        <li class="product__characteristics-item"><b>Длина:</b>95 м.</li>
                    </ul>
                    <div class="product__price-wrapper">
                        <span class="product__price">175.50 руб.</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="pagination">
            <ul class="pagination__list">
                <li class="pagination__item"><a href="" class="link pagination__link">Назад</a></li>
                <li class="pagination__item"><a class="link pagination__link pagination__link--active">1</a></li>
                <li class="pagination__item"><a href="" class="link pagination__link">2</a></li>
                <li class="pagination__item"><a href="" class="link pagination__link">Вперед</a></li>
            </ul>
        </div>

    </div>
</section>
