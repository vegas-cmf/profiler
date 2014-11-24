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
namespace Vegas\Profiler\DataCollector;

use Vegas\Profiler\Exception\EventNotTriggeredException;
use Phalcon\Db\Profiler;

/**
 * Class Query
 * Provides details about database queries used by the request/response.
 * @package Vegas\Profiler\DataCollector
 */
class Query implements DataCollectorInterface
{
    /**
     * @var int
     */
    private $counter = 0;
    
    /**
     * @var array
     */
    private $queries = [];
    
    /**
     * @var \Phalcon\Db\Profiler
     */
    private $dbProfiler;
    
    public function __construct()
    {
        $this->dbProfiler = new Profiler;
    }
    
    public function getListenerType()
    {
        return 'db';
    }
    
    public function beforeQuery($event, $connection)
    {
        $this->dbProfiler->startProfile($connection->getSQLStatement());
    }
    
    public function afterQuery($event, $connection)
    {
        $this->dbProfiler->stopProfile();
        $this->queries[] = [
            'query' => $connection->getSQLStatement(),
            'time'  => $this->dbProfiler->getTotalElapsedSeconds()
        ];
        $this->dbProfiler->reset();
        ++$this->counter;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        if (!isset($this->counter, $this->queries)) {
            throw new EventNotTriggeredException;
        }
        return [
            'counter'   => $this->counter,
            'queries'   => $this->queries
        ];
    }
    
}