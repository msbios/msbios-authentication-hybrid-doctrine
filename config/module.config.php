<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Authentication\Hybrid\Doctrine;

use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'controllers' => [
        'factories' => [
            Controller\HybridController::class =>
                Factory\HybridControllerFactory::class,
        ],
        'aliases' => [
            \MSBios\Authentication\Hybrid\Controller\HybridController::class =>
                Controller\HybridController::class
        ]
    ],

    'service_manager' => [
        'factories' => [
            ProviderManager::class =>
                Factory\ProviderManagerFactory::class
        ],
        'aliases' => [
            \MSBios\Authentication\Hybrid\ProviderManager::class =>
                ProviderManager::class
        ]
    ]

];
