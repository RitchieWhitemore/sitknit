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

                    ['label' => 'Главная', 'icon' => 'file-o', 'url' => ['/main/default/index']],
                    ['label' => 'Администрирование пользователей', 'icon' => 'file-o', 'url' => ['/admin/users/index']],
                    ['label' => 'Справочники', 'icon' => 'folder', 'items' => [
                        ['label' => 'Брэнды', 'icon' => 'file-o', 'url' => ['/admin/shop/brands/index']],
                        ['label' => 'Категории', 'icon' => 'file-o', 'url' => ['/admin/shop/categories/index']],
                        ['label' => 'Материалы', 'icon' => 'file-o', 'url' => ['/admin/shop/materials/index']],
                        ['label' => 'Страны', 'icon' => 'file-o', 'url' => ['/admin/shop/country/index']],
                        ['label' => 'Управление товарами', 'icon' => 'folder', 'items' => [
                            ['label' => 'Товары', 'icon' => 'file-o', 'url' => ['/admin/shop/goods/index']],
                            ['label' => 'Характеристики', 'icon' => 'file-o', 'url' => ['/admin/shop/characteristics/index']],
                            ['label' => 'Значения атрибута', 'icon' => 'file-o', 'url' => ['/admin/attribute-values/index']],
                            ['label' => 'Единицы измерения', 'icon' => 'file-o', 'url' => ['/admin/shop/units/index']],
                        ]],
                        ['label' => 'Управление ценами', 'icon' => 'folder', 'items' => [
                            ['label' => 'Цены', 'icon' => 'file-o', 'url' => ['/trade/prices/index']],
                            [
                                'label' => 'Загрузить цены',
                                'icon'  => 'file-o',
                                'url'   => ['/admin/shop/prices/set-prices']
                            ],
                            [
                                'label' => 'Установить цены вручную',
                                'icon'  => 'file-o',
                                'url'   => ['/admin/shop/prices/index']
                            ],
                        ]],
                        ['label' => 'Контрагенты', 'icon' => 'file-o', 'url' => ['/trade/partners/index']],
                    ]],
                    ['label' => 'Документы', 'icon' => 'folder', 'items' => [
                        ['label' => 'Закупки', 'icon' => 'file-o', 'url' => ['/admin/documents/purchases/index']],
                        ['label' => 'Поступления товара', 'icon' => 'file-o', 'url' => ['/admin/documents/receipts/index']],
                        ['label' => 'Заказы покупателей', 'icon' => 'file-o', 'url' => ['/admin/documents/orders/index']],
                    ]],
                    ['label' => 'Отчеты', 'icon' => 'folder', 'items' => [
                        ['label' => 'Приход', 'icon' => 'file-o', 'url' => ['/admin/shop/reports/debit']],
                        ['label' => 'Расход', 'icon' => 'file-o', 'url' => ['/admin/shop/reports/credit']],
                        ['label' => 'Остатки', 'icon' => 'file-o', 'url' => ['/admin/shop/reports/remaining']],
                        [
                            'label' => 'Прибыль',
                            'icon' => 'file-o',
                            'url' => ['/admin/shop/reports/profit']
                        ],
                    ]]
                ]),
            ]
        ) ?>

    </section>

</aside>
