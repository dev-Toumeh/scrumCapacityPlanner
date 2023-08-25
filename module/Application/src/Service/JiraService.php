<?php
declare(strict_types=1);

namespace Application\Service;


use Application\configuration\AppSessionManager;
use Application\configuration\Config;
use Application\Service\Model\JiraDatenModel;
use Laminas\Http\Client\Adapter\Curl;
use Laminas\Http\Request;

class JiraService extends ServiceAbstract
{
    private $jiraUsername;
    private $jiraPassword;

    public function __construct(Config $configArray, AppSessionManager $session)
    {
        $this->jiraUsername = $session->getCredentials()[self::JIRA_USERNAME];
        $this->jiraPassword = $session->getCredentials()[self::JIRA_PASSWORD];
        parent::__construct($uri = null, $options = []);
    }

    public function getDevelopersInformation(array $requestedDevelopers): array
    {
        $jiraInformation = [];
        foreach ($requestedDevelopers as $developer) {
            $jiraInformation[$developer] = $this->getDeveloperInfo($developer);
        }
        return $jiraInformation;
    }
    private function getDataForOneDeveloper(string $name): string
    {
        $Uri = self::STATIC_URL . $name . self::MAX_RESULT ."&" . self::FIELDS . self::CUSTOM_FIELD_STORY_POINT;
        $this->setUri($Uri);
        $this->setAdapter(Curl::class);
        $this->setMethod(Request::METHOD_GET);
        $this->setOptions([CURLOPT_FOLLOWLOCATION => true]);
        $this->setAuth($this->jiraUsername, $this->jiraPassword);
        $this->send();
        return $this->response->getBody() ;
    }
    private function getDeveloperInfo(string $name): array
    {
        $Issues = $this->getDataForOneDeveloper($name);
        return $this->setDeveloperInfo(JiraDatenModel::setJiraDaten($Issues));
    }

    private function setDeveloperInfo(JiraDatenModel $jiraDatenModel): array
    {
        return [
            self::TICKET_COUNTER => $jiraDatenModel->getTotal(),
            self::TICKETS_WITHOUT_STORY_POINTS => $jiraDatenModel->getTotalNoIssues(),
            self::STORY_POINT_COUNTER => $jiraDatenModel->getTotalStoryPoints()
        ];

    }
    public function hasJiraAccess(string $username, string $password): bool
    {
        $this->setUri(self::USER_INFO_URL);
        $this->setAdapter(Curl::class);
        $this->setMethod(Request::METHOD_GET);
        $this->setOptions([CURLOPT_FOLLOWLOCATION => true]);
        $this->setAuth($username, $password);
        $this->send();

        return $this->response->isSuccess();

    }
}