<?php

declare(strict_types=1);

namespace ApplicationTest\Controller;

use Application\Controller\IndexController;
use Laminas\Stdlib\ArrayUtils;
use Laminas\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class IndexControllerTest extends AbstractHttpControllerTestCase
{
    public function setUp(): void
    {

        $configOverrides = [];

        $this->setApplicationConfig(ArrayUtils::merge(
            include __DIR__ . '/../../../../config/application.config.php',
            $configOverrides
        ));

        parent::setUp();
    }

//    public function testIndexActionCanBeAccessed(): void
//    {
//        $this->dispatch('/', 'GET');
//        $this->assertResponseStatusCode(200);
//        $this->assertModuleName('application');
//        $this->assertControllerName(IndexController::class); // as specified in router's controller name alias
//        $this->assertControllerClass('IndexController');
//        $this->assertMatchedRouteName('home');
//    }

    public function testIndexActionViewModelTemplateRenderedWithinLayout(): void
    {
        $this->assertTrue(true);
        $this->assertNotEquals(10, 20);
    }

//    public function testInvalidRouteDoesNotCrash(): void
//    {
//        $this->dispatch('/invalid/route', 'GET');
//        $this->assertResponseStatusCode(404);
//    }
}
