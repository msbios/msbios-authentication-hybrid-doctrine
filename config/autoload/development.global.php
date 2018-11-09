<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Authentication\Hybrid\Doctrine;

use Zend\ServiceManager\Factory\InvokableFactory;

return [

    'doctrine' => [
        'authentication' => [
            'orm_default' => [
                'identity_class' => \MSBios\Guard\Resource\Doctrine\UserInterface::class,
                'identity_property' => 'username',
                'credential_property' => 'password',
            ],
        ],
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
                InvokableFactory::class,
        ],
        'aliases' => [
            \MSBios\Portal\Doctrine\Controller\IndexController::class =>
                Controller\IndexController::class
        ]
    ],

    'view_manager' => [
        'template_map' => [
            'error/403' =>
                __DIR__ . '/../../view/error/403.phtml',
            'ms-bios/guard/index/index' =>
                __DIR__ . '/../../vendor/msbios/guard/view/ms-bios/guard/index/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../../view',
        ],
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
                \MSBios\Application\Controller\IndexController::class => [
                    // ...
                ],
                \MSBios\Portal\Doctrine\Controller\IndexController::class => [
                    // ...
                ],
                Controller\IndexController::class => [
                    // ...
                ],
            ],
        ],

        'rule_providers' => [
            \MSBios\Guard\Provider\RuleProvider::class => [
                'allow' => [
                    [['USER'], Controller\IndexController::class],
                    [['USER'], \MSBios\Application\Controller\IndexController::class],
                    [['USER'], \MSBios\Portal\Doctrine\Controller\IndexController::class],
                    //[['USER'], \MSBios\Application\Controller\IndexController::class, ['index']],
                    //[['GUEST'], \MSBios\Application\Controller\IndexController::class, [
                    //    'login', 'join', 'reset'
                    //]],
                ],
                'deny' => [
                    // ...
                ]
            ]
        ],
    ],

    \MSBios\Authentication\Hybrid\Module::class => [
        'identity_resolvers' => [
            \MSBios\Authentication\Hybrid\Resolver\EmailResolver::class => 100
        ]
    ]
];
