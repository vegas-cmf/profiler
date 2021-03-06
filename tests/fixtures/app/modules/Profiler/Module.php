<?php
/**
 * This file is part of Vegas package
 *
 * @author Slawomir Zytko <slawomir.zytko@gmail.com>
 * @copyright Amsterdam Standard Sp. Z o.o.
 * @Testpage https://bitbucket.org/amsdard/vegas-phalcon
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Profiler;

class Module extends \Vegas\Mvc\ModuleAbstract
{
    public function __construct()
    {
        $this->namespace = __NAMESPACE__;
        $this->dir = __DIR__;
    }
} 