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
 
namespace Profiler\Controllers\Frontend;

use Vegas\Mvc\Controller\ControllerAbstract,
    Vegas\Profiler\DataCollector\DataCollectorInterface as ProfilerDataCollector,
    Vegas\Mvc\View;

class ProfilerController extends ControllerAbstract
{
    public function showAction($requestId)
    {
        $this->request->isAjax() && $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
        $data = $this->di->getShared(ProfilerDataCollector::DI_NAME)->getData($requestId);
        $this->view->setVar('profiler', $data);
    }
} 