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

interface ResourceParserInterface
{
    /**
     * @param string $resource
     *
     * @return array
     */
    public function parse($resource);
}