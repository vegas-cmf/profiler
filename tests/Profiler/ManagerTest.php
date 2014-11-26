<?php
/**
 * This file is part of Vegas package
 *
 * @author Radosław Fąfara <radek@archdevil.pl>
 * @copyright Amsterdam Standard Sp. Z o.o.
 * @homepage http://vegas-cmf.github.io/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Vegas\Tests\Profiler;

use Vegas\Profiler\Manager as ProfilerManager;
use Vegas\Profiler\DataCollector\DataCollectorInterface as ProfilerDataCollector;

class ManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Phalcon\DI
     */
    private $di;

    public function setUp()
    {
        $this->di = \Phalcon\DI::getDefault();
        $this->di->setShared('environment', function() { return \Vegas\Constants::TEST_ENV; });
        $this->di->setShared('view', function() { return 'fake-view'; });
    }

    public function tearDown()
    {
        $this->di->getShared('eventsManager')->detachAll();
        $this->di->remove('view');
    }

    /**
     * @return array
     */
    private function getDataCollectors()
    {
        if (isset($this->di->get('config')->profiler)) {
            $dataCollectors = (array)$this->di->get('config')->profiler;
        } else {
            $dataCollectors = [];
        }

        $this->assertNotEmpty($dataCollectors, 'Setup DI adding data collector class names under "profiler" key.');
        return $dataCollectors;
    }

    public function testProfilerInitialization()
    {
        $this->di->set(ProfilerDataCollector::DI_NAME, function() {
            return (new ProfilerManager)
                ->setEventsManager($this->di->getShared('eventsManager'));
        }, true);

        $manager = $this->di->get(ProfilerDataCollector::DI_NAME);
        $this->assertInstanceOf('\Vegas\Profiler\Manager', $manager);
    }

    /**
     * @depends testProfilerInitialization
     */
    public function testProfilerAttachesItselfToSpecificViewEvents()
    {
        $profiler = $this->di->get(ProfilerDataCollector::DI_NAME);
        $eventsManager = $this->di->getShared('eventsManager');

        $oldBeforeRenderListeners = count($eventsManager->getListeners('view:beforeRender'));
        $oldAfterRenderListeners = count($eventsManager->getListeners('view:afterRender'));

        $this->assertEquals(0, $oldBeforeRenderListeners);
        $this->assertEquals(0, $oldAfterRenderListeners);

        $profiler->enable([]);

        $newBeforeRenderListeners = count($eventsManager->getListeners('view:beforeRender'));
        $newAfterRenderListeners = count($eventsManager->getListeners('view:afterRender'));

        $this->assertEquals(1, $newBeforeRenderListeners);
        $this->assertEquals(1, $newAfterRenderListeners);
    }

    /**
     * @depends testProfilerInitialization
     */
    public function testProfilerManagerAttachesDataCollectorsToVariousEvents()
    {
        $profiler = $this->di->get(ProfilerDataCollector::DI_NAME);
        $eventsManager = $this->di->getShared('eventsManager');

        $oldDbListenerCount = count($eventsManager->getListeners('db'));
        $oldDispatchListenerCount = count($eventsManager->getListeners('dispatch'));
        $oldViewListenerCount = count($eventsManager->getListeners('view'));

        $profiler->enable($this->getDataCollectors());

        $newDbListenerCount = count($eventsManager->getListeners('db'));
        $newDispatchListenerCount = count($eventsManager->getListeners('dispatch'));
        $newViewListenerCount = count($eventsManager->getListeners('view'));

        $this->assertGreaterThan($oldDbListenerCount, $newDbListenerCount);
        $this->assertGreaterThan($oldDispatchListenerCount, $newDispatchListenerCount);
        $this->assertGreaterThan($oldViewListenerCount, $newViewListenerCount);

        // this is the default interface - we can modify it during profiler manager initialization
        $this->assertNotEmpty($eventsManager->getListeners('db'));
        $this->assertNotEmpty($eventsManager->getListeners('dispatch'));
        $this->assertNotEmpty($eventsManager->getListeners('view'));
        $this->assertContainsOnlyInstancesOf('\Vegas\Profiler\DataCollector\DataCollectorInterface', $eventsManager->getListeners('db'));
        $this->assertContainsOnlyInstancesOf('\Vegas\Profiler\DataCollector\DataCollectorInterface', $eventsManager->getListeners('dispatch'));
        $this->assertContainsOnlyInstancesOf('\Vegas\Profiler\DataCollector\DataCollectorInterface', $eventsManager->getListeners('view'));
    }

    /**
     * @depends testProfilerManagerAttachesDataCollectorsToVariousEvents
     */
    public function testProfilersMustBeExecutedBeforeSerialization()
    {
        $profiler = $this->di->get(ProfilerDataCollector::DI_NAME);
        $eventsManager = $this->di->getShared('eventsManager');

        $profiler->enable($this->getDataCollectors());

        try {

            json_encode($profiler);
            $this->fail();

        } catch (\Exception $e) {

            do {
                $e = $e->getPrevious();
            } while ($e && $e->getPrevious());

            $this->assertInstanceOf('\Vegas\Profiler\Exception\EventNotTriggeredException', $e);
        }

        $eventsManager->fire('db:beforeQuery', $this->di->getShared('db'));
        $this->di->getShared('db')->execute('SELECT 1');
        $eventsManager->fire('db:afterQuery', $this->di->getShared('db'));
        $eventsManager->fire('dispatch:beforeException', $this->di->getShared('dispatcher'), new \Vegas\Exception);
        $eventsManager->fire('dispatch:afterDispatchLoop', $this->di->getShared('dispatcher'));
        $eventsManager->fire('view:afterRender', $this->di->getShared('view'));

        $result = json_encode($profiler);
        $this->assertJson($result);
    }
}