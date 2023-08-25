<?php
declare(strict_types=1);


namespace Application\Service;


use Application\configuration\AppSessionManager;
use Application\configuration\Config;
use Application\Service\Model\Absence;
use Application\Service\Model\AbsenceDatenModel;
use DateTime;
use Dflydev\Hawk\Client\ClientBuilder;
use Dflydev\Hawk\Credentials\Credentials;
use Exception;
use Laminas\Http\Client;
use Laminas\Http\Client\Adapter\Curl;
use Laminas\Http\Headers;
use Laminas\Http\Request as LaminasRequest;

class AbsenceService extends ClientBuilder
{
    protected const ABSENCE_URL = 'https://app.absence.io/api/v2/absences';
    protected const ABSENCE_PRIVILEGE_URL = 'https://app.absence.io/api/v2/users/me';
    protected const CONTENT_TYPE = "Content-Type";
    protected const APPLICATION_JSON = "application/json";
    protected const ABSENCE_ID = 'absenceID';
    protected const DATA = 'data';
    protected const DAYS_COUNT = 'daysCount';
    protected const ADMIN_ID = '000000000000000000001000';
    protected const ROLE_ID = 'roleId';
    protected const LAST_WORKDAY_AFTER_2_WEEKS = 'getLastWorkdayAfter2Weeks';
    protected const FIRST_WORKDAY_BEFORE_25_WEEKS = 'getFirstWorkdayBefore25Weeks';
    protected const SKIP = 'skip';
    protected const LIMIT = 'limit';
    protected const FILTER = 'filter';
    protected const START = 'start';
    protected const END = 'end';
    protected const ASSIGNED_TO_ID = 'assignedToId';
    protected const REASON_ID = 'reasonId';
    protected const RELATIONS = 'relations';
    protected const APPROVED_ID = 'approverId';
    protected const LTE = 'lte';
    protected const GTE = 'gte';
    protected const NE = 'ne';
    protected const REASON_ID_VALUE = "60daf6bab5dc1f0a17142ab4";
    protected const ABSENCE_LAST_25_WEEKS = 'AbsenceLast25weeks';
    protected const ABSENCE_NEXT_2_WEEKS = 'AbsenceNext2weeks';
    protected const MONDAY_THIS_WEEK = 'monday this week';
    protected const LAST_SUNDAY = 'last sunday';
    protected const MINUS_25_WEEKS = '-25 weeks';
    protected const FIRST_MONDAY = 'first monday';
    protected const FRIDAY_THIS_WEEK = 'friday this week';
    protected const NEXT_MONDAY = 'next monday';
    protected const PLUS_2_WEEKS = '+2 weeks';
    protected const LAST_FRIDAY = 'last friday';

    private AppSessionManager $sessionManager;
    private string $hawkHeaderAuthorization;
    protected $config;
    private DateTime $lastWorkdayAfter2Weeks;
    private DateTime $firstWorkdayBefore25Weeks;

    public function __construct(AppSessionManager $sessionManager, Config $config)
    {
        $this->sessionManager = $sessionManager;
        $this->config = $config;
    }

    public function getAbsencePostRequest(string $absenceID): string
    {
        $client = new Client();
        $client->setUri(self::ABSENCE_URL);
        $client->setAdapter(Curl::class);
        $client->setMethod(LaminasRequest::METHOD_POST);
        $client->setRawBody(json_encode($this->getBody($absenceID)));
        $client->setHeaders($this->getHawkHeader());
        $client->send();
        return $client->getResponse()->getBody();
    }

    public function hasAbsencePrivileges(array $data): bool
    {
        $client = new Client();
        $client->setUri('https://app.absence.io/api/v2/users/me');
        $client->setAdapter(Curl::class);
        $client->setMethod(LaminasRequest::METHOD_GET);
        $client->setHeaders($this->getHawkHeader($data));
        $response = $client->send();
        $body = json_decode($response->getBody(), true);
        return $body[self::ROLE_ID] === self::ADMIN_ID;
    }

    private function getHawkHeader($data = []): Headers
    {
        $headers = new Headers();
        $headers->addHeaderLine(self::CONTENT_TYPE, self::APPLICATION_JSON);
        if (!empty($data)) {
            // $headers->addHeaderLine($this->getHawkHeaderLogin($data));
        } else {
            $headers->addHeaderLine($this->getHawkHeaderAuthorization());
        }
        return $headers;
    }

    public function getHawkHeaderAuthorization(): string
    {
        if (!isset($this->hawkHeaderAuthorization)) {
            $client = $this->build();
            $hawkRequest = $client->createRequest($this->getCredentials(), self::ABSENCE_URL,
                LaminasRequest::METHOD_POST);
            $this->hawkHeaderAuthorization = $hawkRequest->header()->fieldName() . ': ' . $hawkRequest->header()->fieldValue();
        }
        return $this->hawkHeaderAuthorization;
    }

    public function getHawkHeaderLogin(array $data): string
    {
        $clientBuilder = new ClientBuilder();
        $client = $clientBuilder->build();
        $hawkRequest = $client->createRequest($this->getCredentials($data), self::ABSENCE_PRIVILEGE_URL,
            LaminasRequest::METHOD_GET);
        return $hawkRequest->header()->fieldName() . ': ' . $hawkRequest->header()->fieldValue();
    }

    private function getBody(string $absenceID): array
    {
        return [
            "skip" => 0,
            "limit" => 200,
            "filter" => [
                "start" => ["$" . "lte" => $this->getLastWorkdayAfter2Weeks()->format('Y-m-d')],
                "end" => ["$" . "gte" => $this->getFirstWorkdayBefore25Weeks()->format('Y-m-d')],
                "assignedToId" => $absenceID,
                "reasonId" => ["$" . "ne" => "60daf6bab5dc1f0a17142ab4"]
            ],
            "relations" => ["assignedToId", "reasonId", "approverId"]
        ];
    }

    private function getCredentials(array $data = []): ?Credentials
    {
        if (!empty($data)) {
            return new Credentials($data['hawkAuthKey'], 'sha256', $data['hawkID']);
        } elseif (isset($this->sessionManager)) {
            $credentials = $this->sessionManager->getCredentials();
            return new Credentials($credentials['hawkAuthKey'], 'sha256', $credentials['hawkId']);
        }
        return null;
    }

    /**
     * this function is responsible for getting the amount od
     * @throws Exception
     */
    public function getDevelopersAbsenceDays(array $developers): array
    {
        return [
            'max.mustermann' =>
                [
                    'AbsenceLast25weeks' => 8,
                    'AbsenceNext2weeks' => 1,
                ]
        ];
    }

    /**
     * @throws Exception
     */
    private function getAbsenceDaysCounter(array $absenceData): array
    {
        $absenceDataModell = AbsenceDatenModel::SetAbsenceDaten(
            $absenceData,
            $this->lastWorkdayAfter2Weeks
        );
        return [
            self::ABSENCE_LAST_25_WEEKS => $absenceDataModell->getAbsenceLast25weeks(),
            self::ABSENCE_NEXT_2_WEEKS => $absenceDataModell->getAbsenceNext2weeks(),
        ];

    }

    private function getFirstWorkdayBefore25Weeks(): DateTime
    {
        if (!isset($this->firstWorkdayBefore25Weeks)) {
            $today = new DateTime();
            $currentWeekMonday = clone $today;
            $currentWeekMonday->modify(self::MONDAY_THIS_WEEK);

            $previousWeekSunday = clone $currentWeekMonday;
            $previousWeekSunday->modify(self::LAST_SUNDAY);

            $before25Weeks = clone $previousWeekSunday;
            $before25Weeks->modify(self::MINUS_25_WEEKS);
            $firstWorkdayBefore25Weeks = clone $before25Weeks;
            $firstWorkdayBefore25Weeks->modify(self::FIRST_MONDAY);
            $this->firstWorkdayBefore25Weeks = $firstWorkdayBefore25Weeks;
        }
        return $this->firstWorkdayBefore25Weeks;
    }

    private function getLastWorkdayAfter2Weeks(): DateTime
    {
        if (!isset($this->lastWorkdayAfter2Weeks)) {
            $today = new DateTime();
            $currentWeekFriday = clone $today;
            $currentWeekFriday->modify(self::FRIDAY_THIS_WEEK);

            $nextWeekMonday = clone $currentWeekFriday;
            $nextWeekMonday->modify(self::NEXT_MONDAY);

            $after2Weeks = clone $nextWeekMonday;
            $after2Weeks->modify(self::PLUS_2_WEEKS);
            $lastWorkdayAfter2Weeks = clone $after2Weeks;
            $lastWorkdayAfter2Weeks->modify(self::LAST_FRIDAY);
            $this->lastWorkdayAfter2Weeks = $lastWorkdayAfter2Weeks;
        }
        return $this->lastWorkdayAfter2Weeks;
    }


}



//    /**
//     * @param $absenceData
//     * @return void
//     * @throws Exception
//     */
//    public function getAbsenceDaysCounter($absenceData): array
//    {
//        $devCounter = [];
//        $today = new DateTime();
//        $devCounter[self::ABSENCE_LAST_25_WEEKS] = 0;
//        $devCounter[self::ABSENCE_NEXT_2_WEEKS] = 0;
//        $startOfSprint = $this->getFirstWorkdayBefore25Weeks();
//        $endOfSprint = $this->getLastWorkdayAfter2Weeks();
//
//        foreach ($absenceData as $data) {
//            $startDate = new DateTime($data[self::START]);
//            $endDate = new DateTime($data[self::END]);
//
//            if ($startDate >= $startOfSprint && $endDate <= $endOfSprint){
//                $devCounter[self::ABSENCE_NEXT_2_WEEKS] += $data[self::DAYS_COUNT];
//            }
//            elseif($startDate >= $startOfSprint
//                && $startDate <= $endOfSprint
//                && $endDate >= $endOfSprint
//            ){
//                $dayCount = $startDate->diff($endOfSprint)->days;
//                $devCounter[self::ABSENCE_NEXT_2_WEEKS] += $dayCount;
//            }
//            elseif($startDate <= $startOfSprint
//                && $endDate <= $endOfSprint
//                && $endDate >= $startOfSprint
//            ){
//                $dayCount = $startOfSprint->diff($endDate)->days;
//                $devCounter[self::ABSENCE_NEXT_2_WEEKS] += $dayCount;
//            }
//            elseif($startDate <= $startOfSprint && $endDate >= $endOfSprint){
//                $devCounter[self::ABSENCE_NEXT_2_WEEKS] += 10;
//            } else {
//                $devCounter[self::ABSENCE_LAST_25_WEEKS] += $data[self::DAYS_COUNT];
//            }
//        }
//        return $devCounter;
//    }
//
//    private function getFirstWorkdayBefore25Weeks(): DateTime
//    {
//        if(!isset($this->firstWorkdayBefore25Weeks)) {
//            $today = new DateTime();
//            $currentWeekMonday = clone $today;
//            $currentWeekMonday->modify(self::MONDAY_THIS_WEEK);
//
//            $previousWeekSunday = clone $currentWeekMonday;
//            $previousWeekSunday->modify(self::LAST_SUNDAY);
//
//            $before25Weeks = clone $previousWeekSunday;
//            $before25Weeks->modify(self::MINUS_25_WEEKS);
//            $firstWorkdayBefore25Weeks = clone $before25Weeks;
//            $firstWorkdayBefore25Weeks->modify(self::FIRST_MONDAY);
//            $this->firstWorkdayBefore25Weeks = $firstWorkdayBefore25Weeks;
//        }
//        return $this->firstWorkdayBefore25Weeks;
//    }
//
//    private function getLastWorkdayAfter2Weeks(): DateTime
//    {
//        if(!isset($this->lastWorkdayAfter2Weeks)) {
//            $today = new DateTime();
//            $currentWeekFriday = clone $today;
//            $currentWeekFriday->modify(self::FRIDAY_THIS_WEEK);
//
//            $nextWeekMonday = clone $currentWeekFriday;
//            $nextWeekMonday->modify(self::NEXT_MONDAY);
//
//            $after2Weeks = clone $nextWeekMonday;
//            $after2Weeks->modify(self::PLUS_2_WEEKS);
//            $lastWorkdayAfter2Weeks = clone $after2Weeks;
//            $lastWorkdayAfter2Weeks->modify(self::LAST_FRIDAY);
//            $this->lastWorkdayAfter2Weeks = $lastWorkdayAfter2Weeks;
//        }
//        return $this->lastWorkdayAfter2Weeks;
//    }