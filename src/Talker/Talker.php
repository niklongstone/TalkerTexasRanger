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

class Talker
{
    /**
     * @var ResourceInterface
     */
    private $resource;

    /**
     * @var array
     */
    private $parsers;

    public function __construct($resource)
    {
        $this->resource = $resource;
    }

    public function setParser(ResourceParserInterface $resourceParser)
    {
        $this->parsers[] = $resourceParser;
    }

    public function call($phrase)
    {
        foreach ($this->$parsers as $parser) {
            $method = $parser->parse($phrase, $this->resource);
            if ($method instanceOf Method) break;
        }
    }
}