<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Authentication\Hybrid\Doctrine;

use Zend\ServiceManager\Factory\InvokableFactory;

return [

    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'params' => [
                    'host' => '127.0.0.1',
                    'user' => 'root',
                    'password' => 'root',
                    'dbname' => 'portal.dev',
                ],
            ],
        ],
    ],

//    'router' => [
//        'routes' => [
//            'home' => [
//                'type' => Literal::class,
//                'options' => [
//                    'route' => '/',
//                    'defaults' => [
//                        'controller' => Controller\IndexController::class,
//                        'action' => 'index',
//                    ],
//                ],
//            ],
//            'application' => [
//                'type' => Segment::class,
//                'options' => [
//                    'route' => '/application[/:action]',
//                    'defaults' => [
//                        'controller' => Controller\IndexController::class,
//                        'action' => 'index',
//                    ],
//                ],
//            ],
//        ],
//    ],

    'controllers' => [
        'factories' => [
            Controller\IndexController::class =>
                InvokableFactory::class,
        ],
        'aliases' => [
            \MSBios\Application\Controller\IndexController::class =>
                Controller\IndexController::class
        ]
    ],

    \MSBios\Theme\Module::class => [
        'default_global_paths' => [
            'default_global_paths' => __DIR__ . '/../../themes/'
        ]
    ],

    \MSBios\Assetic\Module::class => [
        'paths' => [
            __DIR__ . '/../../vendor/msbios/application/themes/default/public/',
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../../view',
        ],
    ],
];
