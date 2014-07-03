<?php
/**
 * This file is part of Vegas package
 *
 * @author Radosław Fąfara <radek@archdevil.pl>
 * @copyright Amsterdam Standard Sp. Z o.o.
 * @homepage https://bitbucket.org/amsdard/vegas-phalcon
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Vegas\Profiler;

use Vegas\Constants,
    Vegas\DI\InjectionAwareTrait,
    Phalcon\DI\InjectionAwareInterface,
    Phalcon\Events\EventsAwareInterface;

/**
 * Class Manager
 * Attaches profiler to the request/response process
 * @package Vegas\Profiler
 */
class Manager implements InjectionAwareInterface, EventsAwareInterface, \JsonSerializable
{
    use InjectionAwareTrait;
    use EventsAwareTrait;   // TODO move it to \Vegas\Events or \Vegas\DI
    
    /**
     * @var string name of profiler module to skip attaching all events
     */
    protected static $profilerModuleName = 'Profiler';
    
    /**
     * @var string common interface for all data collectors
     */
    protected static $handlerInterface = 'Vegas\Profiler\DataCollector\DataCollectorInterface';
    
    /**
     * @var \Vegas\Profiler\DataCollector\DataCollectorInterface[]
     */
    protected $dataCollectors;
    
    /**
     * @var \Vegas\Profiler\Storage
     */
    protected $storage;
    
    /**
     * Creates instance of the profiler handler.
     * @param string|null $moduleName name of profiler module to skip attaching all events for it
     * @param string|null $handlerInterface when specified, use this interface as a base for data collectors
     */
    public function __construct($moduleName = null, $handlerInterface = null)
    {
        if (is_string($handlerInterface) && $moduleName) {
            static::$profilerModuleName = $moduleName;
        }
        
        if (is_string($handlerInterface) && interface_exists($handlerInterface)) {
            static::$handlerInterface = $handlerInterface;
        }
        
        $this->storage = new Storage;
    }
    
    /**
     * Sets up instance of the profiler handler by attaching handlers to appropriate events.
     * We need to provide an array with valid data collectors which will be attached.
     * For example, a memory usage collector will be attached to before & after dispatch loops.
     * @param array $dataCollectors fully qualified classnames list
     * @param string|null $handlerInterface when specified, use this interface as a base for data collectors
     * @return $this
     */
    public function enable(array $dataCollectors = [])
    {
        if (Constants::PROD_ENV === $this->di->get('environment')) {
            return $this;          // No profiler for production
        }
        
        $this->dataCollectors = array_map(function($dataCollector) {
            return new $dataCollector;
        }, array_filter($dataCollectors, [$this, 'filterDataCollector']));
        
        $this->attachHandlers();
        
        return $this;
    }
    
    /**
     * Used as a callback to array_filter to filter out invalid DataCollector classes
     * @param string $dataCollector
     * @return boolean
     */
    protected function filterDataCollector($dataCollector)
    {
        return class_exists($dataCollector)
            && in_array(static::$handlerInterface, class_implements($dataCollector));
    }
    
    /**
     * Creates profiler container in the view.
     * Attaches all data collector classes listeners to appropriate elements of the system.
     * 
     * Saves all collected data for the next request to display.
     */
    protected function attachHandlers()
    {        
        foreach ($this->dataCollectors as $dataCollector) {
            $this->eventsManager->attach($dataCollector->getListenerType(), $dataCollector);
        }
        
        $this->eventsManager->attach('view:beforeRender', function($event, $view){
            $this->di->get('assets')
                ->addCss('assets/css/profiler.css')
                ->addJs('assets/js/profiler.js')
            ;
            $view->setVar('profilerRequestId', $this->storage->getRequestId());
        });
        
        // Profiled request details writer
        $this->eventsManager->attach('view:afterRender', function() {
            if (static::$profilerModuleName === $this->di->getShared('dispatcher')->getModuleName()) {
                return;
            }
            $this->storage->store($this);
        });
    }
    
    /**
     * Finds stored data for specified request. Use it in the reader module
     * @param string $requestId identifier delivered by the profiler in the previous request
     * @param boolean $deleteTemporaryFile whether to remove data from the filesystem after retrieving data
     * @return array raw data
     */
    public function getData($requestId, $deleteTemporaryFile = true)
    {
        $this->storage->setRequestId($requestId);
        
        $data = $this->storage->read();
        if ($deleteTemporaryFile) {
            $this->storage->delete();
        }
        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        $json = [];
        foreach ($this->dataCollectors as $dataCollector) {
            $json[get_class($dataCollector)] = $dataCollector;
        }
        return $json;
    }

}