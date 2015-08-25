<?php
/**
 * This file is part of the Talker Texas Ranger package.
 *
 * (c) 2015 Nicola Pietroluongo <nik.longstone@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Talker\Test\Parser;

use Talker\Parser\DoubleQuotesParser;

class InputParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider textProvider
     */
    public function testParseString($textToParse, $expectation)
    {
        $parser = new DoubleQuotesParser();
        $result = $parser->parse($textToParse);

        $this->assertEquals($expectation, count($result));
    }

    /**
     * @expectedException \ErrorException
     */
    public function testParseStringWithoutDoubleQuotes()
    {
        $parser = new DoubleQuotesParser();
        $parser->parse('nothing to parse');
    }

    public function textProvider()
    {
        return array(
            array('firstSecond "one"', 1),
            array('firstSecondThirdfoo "two" "three"', 2)
        );
    }
}