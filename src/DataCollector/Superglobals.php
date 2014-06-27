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
 * Class Superglobals
 * Provides details about superglobals used in the request
 * @package Vegas\Profiler\DataCollector
 */
class Superglobals implements DataCollectorInterface
{
    /**
     * @var mixed
     */
    private $result;
    
    public function getListenerType()
    {
        return 'dispatch';
    }
    
    public function afterDispatchLoop($event)
    {
        $request = $event->getSource()->getDi()->get('request');
        $this->result = [
            'COOKIE'    => $_COOKIE,
            'GET'       => $request->getQuery(),
            'POST'      => $request->getPost(),
            'PUT'       => $request->getPut(),
            'SERVER'    => $_SERVER,
            'SESSION'   => isset($_SESSION) ? $_SESSION : null
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