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
 * Class Exception
 * Provides details about exceptions raised & handled by ExceptionResolver.
 * @package Vegas\Profiler\DataCollector
 */
class Exception implements DataCollectorInterface
{
    /**
     * @var mixed
     */
    private $result = [];
    
    public function getListenerType()
    {
        return 'dispatch';
    }
    
    public function beforeException($event, $dispatcher, \Exception $exception)
    {
        $this->result[] = [
            'code'          => $exception->getCode(),
            'file'          => $exception->getFile(),
            'message'       => $exception->getMessage(),
            'stacktrace'    => $exception->getTraceAsString()
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return $this->result;
    }
    
}