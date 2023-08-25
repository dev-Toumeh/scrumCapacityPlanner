<?php

declare(strict_types=1);

namespace Application;

use Application\configuration\AppSessionManager;
use Application\Controller\factories\IndexControllerFactory;
use Application\Controller\factories\SearchControllerFactory;
use Application\Service\Factories\AbsenceControllerFactory;
use Laminas\Router\Http\Literal;
use Laminas\ServiceManager\Factory\InvokableFactory;
use Laminas\Session\Config\SessionConfig;
use Laminas\Session\Storage\SessionArrayStorage;
use Laminas\Session\Validator\HttpUserAgent;
use Laminas\Session\Validator\RemoteAddr;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'search' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/check24/search',
                    'defaults' => [
                        'controller' => Controller\SearchController::class,
                        'action'     => 'search',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => IndexControllerFactory::class,
            Controller\SearchController::class => SearchControllerFactory::class,
            Service\AbsenceService::class => AbsenceControllerFactory::class,
            AppSessionManager::class => InvokableFactory::class
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/check24/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
            'check24/search'          =>  __DIR__ . '/../view/application/check24/search.phtml',
            'check24/info'            =>  __DIR__ . '/../view/application/check24/info.phtml',
            'check24/test'            =>  __DIR__ . '/../view/application/check24/testTm.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'session_manager' => [
        'config' => [
            'class' => SessionConfig::class,
            'options' => [
                'name' => 'myapp',
            ],
        ],
        'storage' => SessionArrayStorage::class,
        'validators' => [
            RemoteAddr::class,
            HttpUserAgent::class,
        ],
    ],
];
