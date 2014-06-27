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

/**
 * Trait EventsAwareTrait
 *
 * Can be used for classes implementing EventsAwareInterface
 * Provides methods required by EventsAwareInterface
 * @todo Perhaps move it into more general place in vegas-cmf-core (\Vegas\Events)
 *
 * @package Vegas\Profiler
 */
trait EventsAwareTrait
{
    /**
     * @var \Phalcon\Events\ManagerInterface $eventsManager
     */
    protected $eventsManager;

    /**
     * Sets the event manager
     *
     * @param \Phalcon\Events\ManagerInterface $eventsManager
     * @return $this
     */
    public function setEventsManager($eventsManager)
    {
        $this->eventsManager = $eventsManager;

        return $this;
    }

    /**
     * Returns the internal event manager
     *
     * @return \Phalcon\Events\ManagerInterface
     */
    public function getEventsManager()
    {
        return $this->eventsManager;
    }
}