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

use Vegas\Mvc\Controller\ControllerAbstract,
    Vegas\Exception;

class TestController extends ControllerAbstract
{
    public function indexAction()
    {
        // just render the view
    }
    
    public function exceptionAction()
    {
        $data = '';
        try {
            throw new Exception('Will not be caught by resolver', 416);
        } catch (Exception $ex) {
            $data .= $ex->getMessage();
        }
        $this->view->setVar('data', $data);
        throw new Exception('This exception is expected to to be caught', 404);
    }

    public function queryAction()
    {
        $data = (new \Test\Services\TriggerQuery)->doSomeQueries();
        $this->view->setVar('data', $data);
    }
} 