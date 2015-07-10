<?php
/**
 * This file is part of the Talker package.
 *
 * (c) Nicola Pietroluongo <nik.longstone@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Talker\Test;

use Talker\CamelCaseParser;
use Talker\Talker;

class TalkerTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $this->assertInstanceOf('Talker\Talker', new Talker('Talker\Talker'));
    }

    public function testGetMethods()
    {
        $talker = new Talker('Talker\Test\Fixtures\TestClass');

        $this->assertEquals(array('testMethod'), $talker->getMethods());
    }

    public function testGetParameters()
    {
        $talker = new Talker('Talker\Test\Fixtures\TestClass');

        $this->assertEquals(array('first', 'second'), $talker->getParameters('testMethod'));
    }

    public function testCall()
    {
        $talker = new Talker('Talker\Test\Fixtures\TestClass');
        $talker->setParser(new CamelCaseParser());

        $this->assertTrue($talker->call('test Method'));
    }
}