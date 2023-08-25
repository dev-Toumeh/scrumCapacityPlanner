<?php

namespace ApplicationTest\Service;

use Application\configuration\AppSessionManager;
use Application\configuration\Config;
use Application\Service\AbsenceService;
use Exception;
use http\Client;
use Laminas\Http\Client\Adapter\Curl;
use Laminas\Http\Headers;
use Laminas\Test\PHPUnit\Controller\AbstractControllerTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use ReflectionClass;
use ReflectionException;

class AbsenceServiceTest extends AbstractControllerTestCase
{

    private AbsenceService $absenceService;
    private MockObject $mockAbsenceService;
    private MockObject $mockConfig;

    protected function setUp(): void
    {
        $this->mockSessionManager = $this->createMock(AppSessionManager::class);
        $this->mockConfig = $this->createMock(Config::class);
        $this->absenceService = new AbsenceService($this->mockSessionManager, $this->mockConfig);
        $this->mockAbsenceService = $this->createMock(AbsenceService::class);
    }

    /**
     * @throws ReflectionException
     */
    public function testHasAbsencePrivileges()
    {
        $expectedHawkHeader = new Headers();
        $expectedHawkHeader->addHeaderLine("Content-Type", "application/json");
        $expectedRoleId = '000000000000000000001000';

        $responseBody = json_encode([
            "roleId" => $expectedRoleId,
        ]);

        $response = $this->createMock(LaminasResponse::class);
        $response->method('getBody')->willReturn($responseBody);

        $client = $this->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['setUri', 'setAdapter', 'setMethod', 'setHeaders', 'send'])
            ->getMock();

        $client->expects($this->once())->method('setUri')->with('https://app.absence.io/api/v2/users/me');
        $client->expects($this->once())->method('setAdapter')->with(Curl::class);
        $client->expects($this->once())->method('setMethod')->with('get');
        $client->expects($this->once())->method('setHeaders')->with($expectedHawkHeader);
        $client->expects($this->once())->method('send')->willReturn($response);


        $reflection = new ReflectionClass($this->absenceService);
        $property = $reflection->getProperty('client');
        $property->setValue($this->absenceService, $client);

        $data = []; // Replace with actual data if necessary
        $this->assertTrue($this->absenceService->hasAbsencePrivileges($data));
    }


    /**
     * @throws Exception
     */
    public function testGetDevelopersAbsenceDays(): void
    {
        $this->mockConfig->method('getDevelopersConfigArray')->willReturn($this->getDevelopersConfigArrayTest());
        $this->mockAbsenceService->method('getAbsencePostRequest')->willReturn($this->getDevelopersData());
        $this->assertSame([$this->getExpectedAbsenceData()],  $this->absenceService->getDevelopersAbsenceDays($this->getDevelopers()));

    }

    private function getDevelopers(): array
    {
        return ['max.mustermann'];
    }

    private function getDevelopersConfigArrayTest(): array
    {
        return [
            'max.mustermann' => [
                'first_name' => 'Max',
                'last_name' => 'Mustermann',
                'email' => 'max.mustermann@check24.de',
                'absenceID' => '58404a5f466def2b1be6dfc9',
                'specialty' => 'backend',
                'fullName' => 'Max Mustermann',
            ]
        ];

    }

    private function getDevelopersData($name = 'max.mustermann')
    {
        $data = [
            'max.mustermann' => [
                'skip' => 0,
                'limit' => 200,
                'count' => 3,
                'totalCount' => 3,
                'data' => [
                    0 => [
                        'daysCount' => 3,
                        'start' => '2023-03-24T00:00:00.000Z',
                        'end' => '2023-03-27T00:00:00.000Z',
                    ],
                    1 => [
                        'daysCount' => 5,
                        'start' => '2023-02-04T00:00:00.000Z',
                        'end' => '2023-02-09T00:00:00.000Z',
                    ],
                    2 => [
                        'daysCount' => 1,
                        'start' => '2023-05-19T00:00:00.000Z',
                        'end' => '2023-05-20T00:00:00.000Z',
                    ]
                ],

            ],

            'david.schmidt' => [
                'skip' => 0,
                'limit' => 200,
                'count' => 4,
                'totalCount' => 4,
                'developer' => 'Max.Mustermann',
                'data' => [
                    0 => [
                        'daysCount' => 3,
                        'start' => '2023-04-20T00:00:00.000Z',
                        'end' => '2023-04-23T00:00:00.000Z',
                    ],
                    2 => [
                        'daysCount' => 7,
                        'start' => '2023-04-25T00:00:00.000Z',
                        'end' => '2023-05-02T00:00:00.000Z',

                    ],
                    3 => [
                        'daysCount' => 2,
                        'start' => '2023-06-01T00:00:00.000Z',
                        'end' => '2023-06-03T00:00:00.000Z',
                    ]
                ],

            ],

            'lena.klein' => [
                'skip' => 0,
                'limit' => 200,
                'count' => 3,
                'totalCount' => 3,
                'data' => [
                    0 => [
                        'daysCount' => 5,
                        'start' => '2023-02-20T00:00:00.000Z',
                        'end' => '2023-02-25T00:00:00.000Z',
                    ],
                    1 => [
                        'daysCount' => 4,
                        'start' => '2022-12-20T00:00:00.000Z',
                        'end' => '2022-12-24T00:00:00.000Z',

                    ],
                    2 => [
                        'daysCount' => 6,
                        'start' => '2023-05-23T00:00:00.000Z',
                        'end' => '2023-05-29T00:00:00.000Z',
                    ]
                ]
            ]
        ];
        return json_encode($data[$name]);
    }

    private function getExpectedAbsenceData(): array
    {
        return [
            'max.mustermann' =>
                [
                    'AbsenceLast25weeks' => 8,
                    'AbsenceNext2weeks' => 1,
                ],
            'david.schmidt' =>
                [
                    'AbsenceLast25weeks' => 10,
                    'AbsenceNext2weeks' => 0,
                ],
            'lena.klein' =>
                [
                    'AbsenceLast25weeks' => 9,
                    'AbsenceNext2weeks' => 2,
                ],
        ];

    }

}
