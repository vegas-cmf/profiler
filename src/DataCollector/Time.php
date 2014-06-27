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
namespace Vegas\Profiler\DataCollector;

use Vegas\Profiler\Exception\EventNotTriggeredException;

/**
 * Class Time
 * Provides details about time elapsed during the script
 * @package Vegas\Profiler\DataCollector
 */
class Time implements DataCollectorInterface
{
    /**
     * @var float
     */
    private $startTime;
    
    /**
     * @var float
     */
    private $endTime;
    
    public function __construct()
    {
        $this->startTime = microtime(true);
    }
    
    public function getListenerType()
    {
        return 'view';
    }
    
    public function afterRender()
    {
        $this->endTime = microtime(true);
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        if (!isset($this->endTime, $this->startTime)) {
            throw new EventNotTriggeredException;
        }
        return $this->endTime - $this->startTime;
    }
}