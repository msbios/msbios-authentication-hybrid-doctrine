<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Authentication\Hybrid\Doctrine;

use MSBios\Authentication\AuthenticationServiceInitializer;
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

    'controllers' => [
        'factories' => [
            Controller\IndexController::class =>
                \MSBios\Guard\Factory\IndexControllerFactory::class,
        ],
        'aliases' => [
            \MSBios\Application\Controller\IndexController::class =>
                Controller\IndexController::class
        ],
        'initializers' => [
            new AuthenticationServiceInitializer
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
        'template_map' => [
            'error/403' => __DIR__ . '/../../view/error/403.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../../view',
        ],
    ],

    \MSBios\Hybridauth\Module::class => [

        "base_url" => "http://0.0.0.0:3107/hybridauth/",

        "providers" => [
            "Facebook" => [
                "enabled" => true,
                "keys" => ["id" => "", "secret" => ""], // in development.local.php
                "scope" => ['email', 'user_birthday', 'user_hometown'], // optional
                "photo_size" => 200, // optional
            ],
            "Google" => [
                "enabled" => true,
                "keys" => ["id" => "", "secret" => ""], // in development.local.php
                "scope" =>
                    "https://www.googleapis.com/auth/plus.login ", // . // optional
                // "https://www.googleapis.com/auth/plus.me " . // optional
                // "https://www.googleapis.com/auth/plus.profile.emails.read", // optional
                "access_type" => "offline",   // optional
                "approval_prompt" => "force",     // optional
                "hd" => "domain.com" // optional
            ],
            "Twitter" => [
                "enabled" => true,
                "keys" => ["id" => "", "secret" => ""], // in development.local.php
            ],
        ],

        // If you want to enable logging, set 'debug_mode' to true.
        // You can also set it to
        // - "error" To log only error messages. Useful in production
        // - "info" To log info and error messages (ignore debug messages)
        "debug_mode" => true,

        // Path to file writable by the web server. Required if 'debug_mode' is not false
        "debug_file" => "./data/logs/msbios.authentication.hybrid.log",
    ],

    \MSBios\Guard\Module::class => [
        'resource_providers' => [
            \MSBios\Guard\Provider\ResourceProvider::class => [

                \MSBios\Application\Controller\IndexController::class => [],
                // 'DASHBOARD' => [
                //     'SIDEBAR' => [],
                // ],
            ],
        ],

        'rule_providers' => [
            \MSBios\Guard\Provider\RuleProvider::class => [
                'allow' => [
                    [['USER'], \MSBios\Application\Controller\IndexController::class],
                ],
                'deny' => []
            ]
        ],
    ],

    \MSBios\Authentication\Hybrid\Module::class => [
        /**
         *
         */
        'identity_resolvers' => [
            \MSBios\Authentication\Hybrid\Resolver\EmailResolver::class => 100
        ]
    ]
];
