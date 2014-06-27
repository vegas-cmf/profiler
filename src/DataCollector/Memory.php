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
 * Class Memory
 * Provides details about memory used by the request/response.
 * @package Vegas\Profiler\DataCollector
 */
class Memory implements DataCollectorInterface
{
    /**
     * @var mixed
     */
    private $result;
    
    public function getListenerType()
    {
        return 'dispatch';
    }
    
    public function afterDispatchLoop()
    {
        $this->result = [
            'current'   => memory_get_usage(),
            'peak'      => memory_get_peak_usage()
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        if (!isset($this->result)) {
            throw new EventNotTriggeredException;
        }
        return $this->result;
    }
    
}