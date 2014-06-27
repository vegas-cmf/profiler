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
 * Class Components
 * Provides details about loaded services & run controller in the request.
 * @package Vegas\Profiler\DataCollector
 */
class Components implements DataCollectorInterface
{
    /**
     * @var mixed
     */
    private $result;
    
    public function getListenerType()
    {
       return 'dispatch';
    }
    
    public function afterDispatchLoop($event, $dispatcher)
    {
        $di = $event->getSource()->getDi();
        $this->result = [
            'module'    => $dispatcher->getModuleName(),
            'forwarded' => $dispatcher->wasForwarded(),
            'namespace' => $dispatcher->getNamespaceName(),
            'handler'   => $dispatcher->getHandlerClass(),
            'controller'=> $dispatcher->getControllerName(),
            'action'    => $dispatcher->getActionName(),
            'params'    => $dispatcher->getParams(),
            'services'  => array_keys($di->getServices()),
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