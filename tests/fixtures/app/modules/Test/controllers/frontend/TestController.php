<?php
/**
 * This file is part of Vegas package
 *
 * @author Radosław Fąfara <radek@archdevil.pl>
 * @copyright Amsterdam Standard Sp. Z o.o.
 * @Testpage https://bitbucket.org/amsdard/vegas-phalcon
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace Test\Controllers\Frontend;

use Vegas\Mvc\Controller\ControllerAbstract;

class TestController extends ControllerAbstract
{
    public function indexAction()
    {
        // just render the view
    }

    public function queryAction()
    {
        $data = (new \Test\Services\TriggerQuery)->doSomeQueries();
        $this->view->setVar('data', $data);
    }
} 