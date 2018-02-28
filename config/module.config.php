<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace MSBios\Authentication\Hybrid\Doctrine;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'controllers' => [
        'factories' => [
            Controller\HybridController::class =>
                InvokableFactory::class,
        ],
        'aliases' => [
            \MSBios\Authentication\Hybrid\Controller\HybridController::class =>
                Controller\HybridController::class
        ]
    ],

];
