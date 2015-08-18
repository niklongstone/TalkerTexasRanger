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
        $this->resourceMethods = $this->getMethods($resource);
    }

    public function setParser(ResourceParserInterface $resourceParser)
    {
        $this->parsers[] = $resourceParser;
    }

    public function call($phrase)
    {
        foreach ($this->parsers as $parser) {
            foreach ($this->resourceMethods as $method) {
                $parsedMethod = $parser->parse($method->getName());
                if ($this->guessMatch($phrase, $parsedMethod)) {

                    return true;
                }
            }
        }

        return false;
    }

    public function getMethods($resource)
    {
        try {
            $reflection = new \ReflectionClass($resource);
        } catch (\ReflectionException $e) {
            throw new \Exception($e->getMessage());
        }

        return $this->getMethodsList($reflection->getMethods());
    }

    protected function getMethodsList($reflectionMethods)
    {
        array_walk(
            $reflectionMethods,
            function (&$v) {
                $methodClass = new Method();
                $methodClass->setName($v->getName());
                foreach ($v->getParameters() as $reflectionParameter) {
                    $parametersName[] = $reflectionParameter->getName();
                }
                $methodClass->setParameters($parametersName);
                $v = $methodClass;
            }
        );

        return $reflectionMethods;
    }

    private function guessMatch($source, $context)
    {
        $context = implode(' ', $context);

        return ($source == $context);
    }
}