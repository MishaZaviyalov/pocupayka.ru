<?php

return [

    //MainWindow
    '' => [
        'controller' => 'main',
        'action' => 'index'],
    'contact' => [
        'controller' => 'main',
        'action' => 'contact'],
    'assortment' => [
        'controller' => 'main',
        'action' => 'assortment'],
    'main/assortment/{page:\d+}' => [
        'controller' => 'main',
        'action' => 'assortment'],
    'product' => [
        'controller' => 'main',
        'action' => 'product'],
    'product/{id:\d+}' => [
        'controller' => 'main',
        'action' => 'product'],
    'registration' => [
        'controller' => 'main',
        'action' => 'registration'],
    'authorization' => [
        'controller' => 'main',
        'action' => 'authorization'],
    'recovery' => [
        'controller' => 'main',
        'action' => 'recovery'],
    'logout' => [
        'controller' => 'main',
        'action' => 'logout',
    ],

//    Start Test

    'assortment/card' => [
        'controller' => 'main',
        'action' => 'card'
    ],

    'assortment/add/{id:\d+}' => [
        'controller' => 'main',
        'action' => 'add'
    ],
    'assortment/remove/{id:\d+}' => [
        'controller' => 'main',
        'action' => 'remove'
    ],

    'assortment/clean' => [
        'controller' => 'main',
        'action' => 'clean'
    ],

    'assortment/formulate' => [
        'controller' => 'main',
        'action' => 'formulate'
    ],

    'order' => [
        'controller' => 'main',
        'action' => 'order'
    ],

    'order/{id:\d+}' => [
        'controller' => 'main',
        'action' => 'orderId'
    ],

    'assortment/success/{id:\d+}' => [
        'controller' => 'main',
        'action' => 'success'
    ],

    'profile' => [
        'controller' => 'main',
        'action' => 'profile'
    ],

    'order/products/{id:\d+}' => [
        'controller' => 'main',
        'action' => 'orderProduct'
    ],

// End test

    // AdminController
    'admin/login' => [
        'controller' => 'admin',
        'action' => 'login',
    ],
    'admin/logout' => [
        'controller' => 'admin',
        'action' => 'logout',
    ],
    'admin/add' => [
        'controller' => 'admin',
        'action' => 'add',
    ],
    'admin/edit/{id:\d+}' => [
        'controller' => 'admin',
        'action' => 'edit',
    ],
    'admin/delete/{id:\d+}' => [
        'controller' => 'admin',
        'action' => 'delete',
    ],
    'admin/products/{page:\d+}' => [
        'controller' => 'admin',
        'action' => 'products',
    ],
    'admin/products' => [
        'controller' => 'admin',
        'action' => 'products',
    ],

    'admin/orders' => [
        'controller' => 'admin',
        'action' => 'orders',
    ],
    'admin/orders/{id:\d+}' => [
        'controller' => 'admin',
        'action' => 'order',
    ],
    
];