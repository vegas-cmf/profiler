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
namespace Test\Models;

class Sample extends \Vegas\Db\Decorator\ModelAbstract
{
    protected $id;
    public $type;
    public $value;
    protected $created_at;
    protected $updated_at;
    
    public function getSource()
    {
        return 'vegas_sample';
    }
}
 
