<?php
/**
 * This file is part of the Talker Texas Ranger package.
 *
 * (c) 2015 Nicola Pietroluongo <nik.longstone@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Talker\Parser;

/**
 * Class CamelCaseParser.
 *
 * Creates a single string from a camel case one.
 * example: 'firstSecond' will give array('first', 'second');
 */
final class CamelCaseParser implements ResourceParserInterface
{
    /**
     * {@inheritdoc}
     */
    public function parse($resource)
    {
        $pattern = '/([a-z]+)|([A-Z]{1}[a-z]*)/';
        preg_match_all($pattern, $resource, $matches);

        return $matches[0];
    }
}