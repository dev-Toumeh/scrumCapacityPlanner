<?php
declare(strict_types=1);
/**
 * SearchControllerFactory.php
 *
 * @copyright   Copyright (c) 2023 CHECK24 Vergleichsportal Reise GmbH München
 * @author      Naseem Toumeh <Naseem.Toumeh@check24.de>
 * @since       01.04.2023
 */

namespace Application\Controller\factories;

use Application\configuration\Config;
use Application\Controller\SearchController;
use Application\Service\AbsenceService;
use Application\Service\JiraService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;


class SearchControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): SearchController
    {
        $configArray = $container->get(Config::class);
        $absenceController = $container->get(AbsenceService::class);
        $jiraController = $container->get(JiraService::class);
        return new SearchController($configArray, $absenceController, $jiraController);
    }

}
