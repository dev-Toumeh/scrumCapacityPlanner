<?php
declare(strict_types=1);


namespace Application\configuration;

use Laminas\Session\Container;
use Laminas\Session\ManagerInterface;
use Laminas\Session\SessionManager;
use Laminas\Session\Storage\SessionArrayStorage;


class AppSessionManager extends SessionManager implements ManagerInterface
{
    public function __construct()
    {
        parent::__construct();
        $this->setStorage(new SessionArrayStorage());
        $this->start();
    }

    public function setCredentials($jiraUsername, $jiraPassword, $hawkId, $hawkAuthKey)
    {
        $sessionContainer = new Container('mySession');
        $sessionContainer->jiraUsername = $jiraUsername;
        $sessionContainer->jiraPassword = $jiraPassword;
        $sessionContainer->hawkId = $hawkId;
        $sessionContainer->hawkAuthKey = $hawkAuthKey;

        $this->writeClose(); // Save the session data
    }

    public function getCredentials(): array
    {
        $sessionContainer = new Container('mySession');
        return [
            'jiraUsername' => $sessionContainer->jiraUsername,
            'jiraPassword' => $sessionContainer->jiraPassword,
            'hawkId' => $sessionContainer->hawkId,
            'hawkAuthKey' => $sessionContainer->hawkAuthKey,
        ];
    }
}