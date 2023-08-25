<?php
declare(strict_types=1);


namespace Application\Controller;

use Application\configuration\Config;
use Application\Service\AbsenceService;
use Application\Service\JiraService;
use Exception;
use Form\InfoForm;
use Form\SearchForm;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;


class SearchController extends AbstractController
{
    private Config $config;
    private AbsenceService $absence;
    private JiraService $jira;

    public function __construct(
        Config         $config,
        AbsenceService $absenceController,
        JiraService $jiraController
    )
    {
        $this->config = $config;
        $this->jira = $jiraController;
        $this->absence = $absenceController;
    }

    /**
     * @throws Exception
     */
    public function searchAction(): ViewModel
    {
        $request = $this->getRequest();

        if ($request->isPost()) {
            $params = $this->params()->fromPost();
            $requestedDevelopers = $this->getRequestedDevelopers($params);
            $jiraDevelopersInfo = $this->jira->getDevelopersInformation($requestedDevelopers);
            $developersAbsenceDays = $this->absence->getDevelopersAbsenceDays($requestedDevelopers);
            $teamCapacity = $this->getTeamCapacity($jiraDevelopersInfo, $developersAbsenceDays);

            $view = new ViewModel([self::TEAM_CAPACITY => $teamCapacity, self::INFO_FORM => new infoForm()]);
            return $view->setTemplate(self::TEMPLATE_CHECK24_INFO);
        }
        $searchForm = new SearchForm($this->config);
        $view = new ViewModel([self::SEARCH_FORM => $searchForm]);
        return $view->setTemplate(self::TEMPLATE_CHECK24_SEARCH);
    }

    private function getRequestedDevelopers(array $params): array
    {
        $chosenEmployees = [];
        unset($params[self::SUBMIT]);
        foreach ($params as $name => $available) {
            $chosenEmployees[] = str_replace('_', '.', $name);
        }
        return $chosenEmployees;
    }

    public function getTeamCapacity(array $jiraDevelopersInfo, array $developersAbsenceDays): ?array
    {
        $capacity = [];
        foreach ($jiraDevelopersInfo as $name => $devInfo) {
                $capacity[$name] = $this->getCapacityProDeveloper($devInfo, $name, $developersAbsenceDays);
        }
        return $capacity;
    }

    /**
     * @param $devInfo
     * @param $name
     * @param $developersAbsenceDays
     * @return array
     */
    public function getCapacityProDeveloper($devInfo, $name, $developersAbsenceDays): array
    {
        $weeks = $this->config->getWeeks();

        return [
            self::FULL_NAME => $this->config->getFullName($name),
            self::SPECIALTY => $this->config->getSpecialty($name),
            self::WITHOUT_SP => $devInfo[self::WITHOUT_SP],
            self::WOCHEN => $weeks,
            self::ABSENCE_DAYS => $developersAbsenceDays[$name][self::ABSENCE_LAST_25_WEEKS],
            self::SP_LAST_25_WEEKS => $devInfo[self::SP_LAST_25_WEEKS],
            self::FACTOR => $devInfo[self::SP_LAST_25_WEEKS] / (($weeks * 5) - $developersAbsenceDays[$name][self::ABSENCE_LAST_25_WEEKS]),
            self::PFAK => $this->decimalToRoundedNumber($devInfo[self::SP_LAST_25_WEEKS] / (($weeks * 5) - $developersAbsenceDays[$name][self::ABSENCE_LAST_25_WEEKS])),
            self::DSPR => 10 - $developersAbsenceDays[$name][self::ABSENCE_NEXT_2_WEEKS],
            self::SP => $this->multiplyPercentageByNumber(
                $this->decimalToRoundedNumber($devInfo[self::SP_LAST_25_WEEKS] / (($weeks * 5) - $developersAbsenceDays[$name][self::ABSENCE_LAST_25_WEEKS])),
                10 - $developersAbsenceDays[$name][self::ABSENCE_NEXT_2_WEEKS]
            )
        ];
    }

    private function decimalToRoundedNumber($decimal)
    {
        $multiplied = $decimal * 100;
        return round($multiplied / 10) * 10;
    }

    private function multiplyPercentageByNumber($percentage, $number): float
    {
        $decimal = $percentage / 100;
        $result = $decimal * $number;
        return round($result);
    }
}
