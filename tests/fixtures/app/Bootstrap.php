<?php
/**
 * This file is part of Vegas package
 *
 * @author Slawomir Zytko <slawomir.zytko@gmail.com>
 * @copyright Amsterdam Standard Sp. Z o.o.
 * @homepage https://bitbucket.org/amsdard/vegas-phalcon
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Vegas\Db\Mapping\Json;
use Vegas\Db\MappingManager;
use Vegas\Profiler\Manager as ProfilerManager;
use Vegas\Profiler\DataCollector\DataCollectorInterface as ProfilerDataCollector;

class Bootstrap extends \Vegas\Application\Bootstrap
{
    public function setup()
    {
        parent::setup();
        $this->initDbMappings();
        $this->initDb();
        $this->initProfiler();

        return $this;
    }

    protected function initDbMappings()
    {
        $mappingManager = new MappingManager();
        $mappingManager->add(new Json());
    }
    
    protected function initDb()
    {
        $di = $this->di;
        $di->set('db', function() use ($di) {
            $arrayConfig = (array)$this->config->db;
            $db = new \Phalcon\Db\Adapter\Pdo\Sqlite($arrayConfig);
            $db->setEventsManager($di->getShared('eventsManager'));
            return $db;
        }, true);
    }
    
    protected function initProfiler()
    {
        if (isset($this->config->profiler)) {
            $dataCollectors = (array)$this->config->profiler;
        } else {
            $dataCollectors = [];
        }
        
        $di = $this->di;
        $di->set(ProfilerDataCollector::DI_NAME, function() use ($di) {
            return (new ProfilerManager)
                ->setEventsManager($di->getShared('eventsManager'));
        }, true);
        $di->get(ProfilerDataCollector::DI_NAME)->enable($dataCollectors);
    }

    /**
     * Start handling MVC requests
     *
     * @param null $uri
     * @return string
     */
    public function run($uri = null)
    {
        return $this->application->handle($uri)->getContent();
    }
} 