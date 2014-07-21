<?php
/**
 * This file is part of Vegas package
 *
 * @author Slawomir Zytko <slawomir.zytko@gmail.com>
 * @copyright Amsterdam Standard Sp. Z o.o.
 * @homepage https://bitbucket.org/amsdard/vegas-phalcon
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Phalcon\DiInterface;
use Vegas\DI\ServiceProviderInterface;

/**
 * Class DbServiceProvider
 */
class SqliteServiceProvider implements ServiceProviderInterface
{
    const SERVICE_NAME = 'db';

    /**
     * {@inheritdoc}
     */
    public function register(DiInterface $di)
    {
        $di->set(self::SERVICE_NAME, function() use ($di) {
            $arrayConfig = (array)$di->get('config')->{self::SERVICE_NAME};
            $db = new \Phalcon\Db\Adapter\Pdo\Sqlite($arrayConfig);
            $db->setEventsManager($di->getShared('eventsManager'));
            return $db;
        }, true);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getDependencies()
    {
        return [];
    }
    
} 
