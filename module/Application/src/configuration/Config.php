<?php
declare(strict_types=1);


namespace Application\configuration;

use Laminas\Di\Config as DiConfig;

class Config extends DiConfig
{
    private array $configArray;

    public function __construct($configArray = [])
    {
        if (empty($configArray)) {
            $this->configArray = include __DIR__ . '/../../config/config.local.php';
        } else {
            $this->configArray = $configArray;
        }
        parent::__construct($this->configArray);
    }

    public function getDevelopersConfigArray(): array
    {
        return $this->configArray['developers'];
    }

    public function getWeeks()
    {
        return $this->configArray['weeks'];
    }

    public function getSpecialty(string $name): string
    {
        return $this->configArray['developers'][strtolower($name)]['specialty'];
    }

    public function getFullName($name)
    {
        return $this->configArray['developers'][strtolower($name)]['fullName'];
    }

}
