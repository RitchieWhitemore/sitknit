<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items'           => array_filter([

                    ['label' => 'Главная', 'url' => ['/main/default/index']],
                    ['label' => 'Администрирование пользователей', 'url' => ['/admin/users/index']],
                    ['label' => 'Справочники', 'items' => [
                        ['label' => 'Брэнды', 'url' => ['/admin/shop/brands/index']],
                        ['label' => 'Категории', 'url' => ['/admin/shop/categories/index']],
                        ['label' => 'Составы (категории)', 'url' => ['/admin/compositions/index']],
                        ['label' => 'Страны', 'url' => ['/admin/shop/country/index']],
                        ['label' => 'Управление товарами', 'items' => [
                            ['label' => 'Товары', 'url' => ['/admin/goods/index']],
                            ['label' => 'Атрибуты', 'url' => ['/admin/attributes/index']],
                            ['label' => 'Значения атрибута', 'url' => ['/admin/attribute-values/index']],
                            ['label' => 'Единицы измерения', 'url' => ['/admin/units/index']],
                            ['label' => 'Изображения', 'url' => ['/admin/images/index']],
                        ]],
                        ['label' => 'Управление ценами', 'items' => [
                            ['label' => 'Цены', 'url' => ['/trade/prices/index']],
                            ['label' => 'Установить цены', 'url' => ['/trade/prices/set-prices']],
                        ]],
                        ['label' => 'Контрагенты', 'url' => ['/trade/partners/index']],
                    ]],
                    ['label' => 'Документы', 'items' => [
                        ['label' => 'Поступления товара', 'url' => ['/trade/receipts/index']],
                        ['label' => 'Заказы покупателей', 'url' => ['/trade/orders/index']],
                    ]],


                ]),
            ]
        ) ?>

    </section>

</aside>
