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
 * Interface ResourceParserInterface
 *
 * Provides an interface for string parse.
 */
interface ResourceParserInterface
{
    /**
     * @param string $resource
     *
     * @return array
     */
    public function parse($resource);
}