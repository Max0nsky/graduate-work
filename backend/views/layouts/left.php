<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="" class="img-circle"/>
            </div>
            <div class="pull-left info">
                <p><?= Yii::$app->user->identity->username; ?></p>

            </div>
        </div>

        <!-- search form -->
        <!-- <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form> -->
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Меню', 'options' => ['class' => 'header']],
                    [
                        'label' => 'Оценка уязвимостей',
                        'icon' => 'calculator',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Cvss-v2', 'icon' => 'plus-circle', 'url' => ['/audit/cvss'],],
                            ['label' => 'Cvss-v3.1', 'icon' => 'plus-circle', 'url' => ['/audit/cvss-three'],],
                        ],
                    ],
                    [
                        'label' => 'Объекты',
                        'icon' => 'circle',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Объекты', 'icon' => 'circle', 'url' => ['/object-system']],
                            ['label' => 'Категории объектов', 'icon' => 'file', 'url' => ['/object-category'],],
                        ],
                    ],
                    [
                        'label' => 'Логи',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Логи', 'icon' => 'file', 'url' => ['/log'],],
                            ['label' => 'Категории логов', 'icon' => 'file', 'url' => ['/log-category'],],
                        ],
                    ],

                    ['label' => 'Угрозы', 'icon' => 'bomb', 'url' => ['/threat']],
                    ['label' => 'Аудит безопасности', 'icon' => 'list', 'url' => ['/audit']],
                    ['label' => 'Рекомендации', 'icon' => 'book', 'url' => ['/recommendation']],
                    // ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    // [
                    //     'label' => 'Some tools',
                    //     'icon' => 'share',
                    //     'url' => '#',
                    //     'items' => [
                    //         ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'],],
                    //         ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug'],],
                    //         [
                    //             'label' => 'Level One',
                    //             'icon' => 'circle-o',
                    //             'url' => '#',
                    //             'items' => [
                    //                 ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
                    //                 [
                    //                     'label' => 'Level Two',
                    //                     'icon' => 'circle-o',
                    //                     'url' => '#',
                    //                     'items' => [
                    //                         ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                    //                         ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                    //                     ],
                    //                 ],
                    //             ],
                    //         ],
                    //     ],
                    // ],
                ],
            ]
        ) ?>

    </section>

</aside>
