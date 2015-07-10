<?php
/**
 * This file is part of the Talker package.
 *
 * (c) Nicola Pietroluongo <nik.longstone@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Talker;

class CamelCaseParser implements ResourceParserInterface
{
    public function parse($resource)
    {
        $pattern = '/([a-z]+)|([A-Z]{1}[a-z]*)/';
        preg_match_all($pattern, $resource, $matches);

        return $matches[0];
    }
}