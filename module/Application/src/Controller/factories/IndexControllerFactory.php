<?php
declare(strict_types=1);

namespace Application\Controller\factories;

use Application\configuration\AppSessionManager;
use Application\configuration\Config;
use Application\Controller\IndexController;
use Application\Service\AbsenceService;
use Application\Service\JiraService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class IndexControllerFactory  implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): IndexController
    {
        $configArray = $container->get(Config::class);
        $absence = $container->get(AbsenceService::class);
        $jira = $container->get(JiraService::class);
        $sessionManager = $container->get(AppSessionManager::class);
        return new IndexController($absence, $jira, $sessionManager);
    }

}
