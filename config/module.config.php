<?php
/**
 *
 */
return [
    'rumeaulib_admin' => [
        'override_layout' => true,
        'admin_layout'    => 'layout/admin',
    ],

    'rumeaulib_appconfig' => [
        'forms' => [
            'rumeaulib_admin' => 'RumeauLibAdmin\Form\AppConfig\Config',
        ],
    ],

    'controllers' => [
        'invokables' => [
            'RumeauLibAdmin\Controller\Admin' => 'RumeauLibAdmin\Controller\AdminController',
        ],
    ],

    'service_manager' => [
        'factories' => [
            'nav_admin' => 'RumeauLibAdmin\Navigation\Service\AdminNavigationFactory',
        ],
    ],

    'router' => [
        'routes' => [
            'admin' => [
                'type' => 'literal',
                'options' => [
                    'route'    => '/admin',
                    'defaults' => [
                        '__NAMESPACE__' => 'RumeauLibAdmin\Controller',
                        'controller' => 'admin',
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => true,
            ],
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view'
        ],
        'template_map' => [
            'layout/admin' => __DIR__ . '/../view/layout/admin.phtml',
        ]
    ],
];
