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

/**
 * Interface DataCollectorInterface
 * Specifies the contract which has to be fullfilled by all profiler data collectors.
 * Data collectors are light classes which are used as event listeners to prepare data for profiler.
 * 
 * @see http://docs.phalconphp.com/pl/latest/reference/events.html to acknowledge how to write them
 * Example attachable hooks:
 * http://docs.phalconphp.com/pl/latest/reference/dispatching.html#dispatch-loop-events
 * http://docs.phalconphp.com/pl/latest/reference/views.html#view-events
 * 
 * JsonSerialization is required to dump the data into file between requests.
 * Serialization is performed after all tasks so that full data is collected.
 * 
 * @package Vegas\Profiler\DataCollector
 */
interface DataCollectorInterface extends \JsonSerializable
{
    /**
     * Name used to get profiler service from DI container
     */
    const DI_NAME = 'profiler';
    
    /**
     * Specifies type where we need to attach the listener
     * @return string
     */
    public function getListenerType();
}
