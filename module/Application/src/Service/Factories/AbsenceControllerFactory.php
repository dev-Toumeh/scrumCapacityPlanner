<?php
declare(strict_types=1);

namespace Application\Service\Factories;

use Application\configuration\Config;
use Application\Service\AbsenceService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class AbsenceControllerFactory  implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): AbsenceService
    {
        $sessionManager = $container->get('MySessionManager');
        $config = $container->get(Config::class);
        return new AbsenceService($sessionManager, $config);
    }

}
