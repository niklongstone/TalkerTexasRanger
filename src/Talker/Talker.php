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
        $this->resourceMethods = $this->getMethods();
    }

    public function setParser(ResourceParserInterface $resourceParser)
    {
        $this->parsers[] = $resourceParser;
    }

    public function call($phrase)
    {
        foreach ($this->parsers as $parser) {
            foreach($this->resourceMethods as $methodName)
            $parsedMethod = $parser->parse($methodName);

            return $this->guessMatch($phrase, $parsedMethod);
        }

        return false;
    }

    public function getMethods()
    {
        try {
            $reflection = new \ReflectionClass($this->resource);
        } catch(\ReflectionException $e) {
            throw new \Exception($e->getMessage());
        }
        $methods = $reflection->getMethods();
        array_walk(
            $methods,
            function (&$v) {
                $v = $v->getName();
            }
        );

        return $methods;
    }

    public function getParameters($method)
    {
        try {
            $reflectionMethod = new \ReflectionMethod($this->resource, $method);
            //$reflection = new \ReflectionParameter(array($this->resource, $method));
        } catch(\ReflectionException $e) {
            throw new \Exception($e->getMessage());
        }
        $params = $reflectionMethod->getParameters();
        array_walk(
            $params,
            function (&$v) {
                $v = $v->getName();
            }
        );

        return $params;
    }

    private function guessMatch($source, $context)
    {
        $context = implode(' ', $context);

        return ($source == $context);
    }
}