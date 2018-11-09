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
            Controller\IndexController::class =>
                InvokableFactory::class,
        ],
        'aliases' => [
            \MSBios\Authentication\Hybrid\Controller\HybridController::class =>
                Controller\HybridController::class
        ]
    ],

    'service_manager' => [
        'factories' => [
            ProviderManager::class =>
                Factory\ProviderManagerFactory::class,

            // resolvers
            Resolver\EmailResolver::class =>
                Factory\EmailResolverFactory::class,
            Resolver\PhoneResolver::class =>
                Factory\PhoneResolverFactory::class
        ],
        'aliases' => [
            \MSBios\Authentication\Hybrid\ProviderManager::class =>
                ProviderManager::class,

            // resolvers
            \MSBios\Authentication\Hybrid\Resolver\EmailResolver::class =>
                Resolver\EmailResolver::class,
            \MSBios\Authentication\Hybrid\Resolver\PhoneResolver::class =>
                Resolver\PhoneResolver::class,
        ]
    ]

];
