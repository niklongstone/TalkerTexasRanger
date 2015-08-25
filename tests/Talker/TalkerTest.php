<?php
/**
 * This file is part of the Talker Texas Ranger package.
 *
 * (c) 2015 Nicola Pietroluongo <nik.longstone@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Talker\Test;

use Talker\Talker;
use Talker\Test\Fixtures\TestClass;
use Talker\Test\Fixtures\TestClassWithNoMethods;

class TalkerTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $this->assertInstanceOf('Talker\Talker', new Talker(new TestClass()));
    }

    public function testCall()
    {
        $talker = new Talker(new TestClass());

        $this->assertTrue($talker->call('test Method "1" and "2"'));
    }

    /**
     * @expectedException \ErrorException
     */
    public function testResourceClassNotExist()
    {
        new Talker('test');
    }

    /**
     * @expectedException \ErrorException
     */
    public function testNonExistingMethodPhrase()
    {
        $talker = new Talker(new TestClass());
        $talker->call('test I am not here "1" and "2"');
    }

    /**
     * @expectedException \ErrorException
     */
    public function testClassWithoutMethods()
    {
        $talker = new Talker(new TestClassWithNoMethods());

        $this->assertFalse($talker->call('test I am not here "1" and "2"'));
    }
}