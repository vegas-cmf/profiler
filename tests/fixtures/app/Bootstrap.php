<?php
/**
 * This file is part of Vegas package
 *
 * @author Slawomir Zytko <slawomir.zytko@gmail.com>
 * @copyright Amsterdam Standard Sp. Z o.o.
 * @homepage http://vegas-cmf.github.io/
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
        $this->initProfiler();

        return $this;
    }

    protected function initDbMappings()
    {
        $mappingManager = new MappingManager();
        $mappingManager->add(new Json());
    }
    
    protected function initProfiler()
    {
        if (isset($this->config->profiler)) {
            $dataCollectors = (array)$this->config->profiler;
        } else {
            $dataCollectors = [];
        }

        $this->di->set(ProfilerDataCollector::DI_NAME, function() {
            return (new ProfilerManager)
                ->setEventsManager($this->di->getShared('eventsManager'));
        }, true);
        $this->di->get(ProfilerDataCollector::DI_NAME)->enable($dataCollectors);
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