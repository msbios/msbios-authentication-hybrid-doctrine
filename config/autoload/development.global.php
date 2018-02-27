<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
return [
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
];
