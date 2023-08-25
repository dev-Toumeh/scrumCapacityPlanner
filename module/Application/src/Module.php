<?php

declare(strict_types=1);

namespace Application;

use Application\configuration\AppSessionManager;
use Application\configuration\Config;
use Application\Controller\factories\SearchControllerFactory;
use Application\Controller\SearchController;
use Application\Service\AbsenceService;
use Application\Service\Factories\AbsenceControllerFactory;
use Application\Service\Factories\JiraControllerFactory;
use Application\Service\JiraService;
use Laminas\ModuleManager\Feature\ConfigProviderInterface;
use Laminas\ModuleManager\Feature\ServiceProviderInterface;
use Laminas\ServiceManager\Factory\InvokableFactory;

class Module implements
    ServiceProviderInterface,
    ConfigProviderInterface
{
    public function getConfig(): array
    {
        /** @var array $config */
        $config = include __DIR__ . '/../config/module.config.php';
        return $config;
    }

    public function getServiceConfig(): array
    {
        return [
            'aliases' => [
                'MySessionManager' => AppSessionManager::class,
            ],
            'factories' => [
                JiraService::class => JiraControllerFactory::class,
                AbsenceService::class => AbsenceControllerFactory::class,
                SearchController::class => SearchControllerFactory::class,
                Config::class => InvokableFactory::class,
            ]
        ];
    }
}
