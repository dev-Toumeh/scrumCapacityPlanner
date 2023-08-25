<?php
declare(strict_types=1);


namespace Application\Service\Factories;



use Application\configuration\Config;
use Application\Service\JiraService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class JiraControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): JiraService
    {
        $configArray = $container->get(Config::class);
        $session = $container->get('MySessionManager');
        return new JiraService($configArray, $session);
    }
}
