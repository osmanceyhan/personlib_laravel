<?php return [
    [
        'title' => 'Anasayfa',
        'url' => 'index',
        'main_route' => 'index',
        'icon' => 'uil-dashboard',
        'route_type' => 'route',
        'permission' => ['ADMIN','MANAGER','EMPLOYEE'],
    ],

    [
        'main_route' => 'employees.index',
        'title' => 'Çalışanlar',
        'url' => 'employees.index',
        'icon' => 'uil-dashboard',
        'route_type' => 'route',
        'permission' => ['ADMIN','MANAGER','EMPLOYEE'],
    ],

    [
        'title' => 'Talepler',
        'url' => 'requests.index',
        'main_route' => 'requests.index',
        'icon' => 'uil-dashboard',
        'route_type' => 'route',
        'permission' => ['ADMIN','MANAGER','EMPLOYEE'],
    ],

    [
        'title' => 'Şirket Ayarları',
        'icon' => 'uil-cog',
        'url' => 'company.show',
        'main_route' => 'company.show',
        'route_type' => 'route',
        'permission' => ['MANAGER'],
    ],
    [
        'title' => 'Ayarlar',
        'icon' => 'uil-cog',
        'url' => 'defination.index',
        'main_route' => 'defination.index',
        'route_type' => 'route',
        'permission' => ['ADMIN'],
    ],
];
