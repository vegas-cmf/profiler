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
namespace Test\Services;

use Test\Models\Sample;

/**
 * Just a sample class which performs some SQL database queries.
 */
class TriggerQuery
{
    public function doSomeQueries()
    {
        $val = rand();
        for ($i = 0; $i < 5; ++$i) {
            $model = new Sample;
            $model->type = 'test';
            $model->value = $val + $i;
            $model->save();
        }
        
        $first = Sample::findFirst(['value' => $val]);
        $type = $first->type;   // some random operations to access data
        $value = $first->value;
        return [$type, $value];
    }
}
