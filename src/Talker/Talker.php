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

final class Talker
{
    /**
     * @var ResourceInterface
     */
    private $resource;

    /**
     * @var array
     */
    private $parser;

    public function __construct($resource)
    {
        if (!get_class($resource)) {
            throw new \ErrorException("The class defined doesn't exists");
        }
        $this->resource = $resource;
        $this->resourceMethods = $this->getMethods($resource);
        $this->parser = new CamelCaseParser();
    }

    public function call($phrase)
    {
        foreach ($this->resourceMethods as $method) {
            $parsedMethod = $this->parser->parse($method->getName());

            if ($this->guessMatch($phrase, $parsedMethod)) {
                $parameters = $this->getParametersFromCall($phrase);

                return $this->runMethod($method, $parameters);
            }
        }

        return false;
    }

    public function overrideDefaultParser(ResourceParserInterface $resourceParser)
    {
        $this->parser = $resourceParser;
    }

    protected function runMethod(Method $method, array $parameters)
    {
        call_user_func_array(array($this->resource, $method->getName()), $parameters);

        return true;
    }

    protected function getMethods($resource)
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
                $v = $this->createMethod($v);
            }
        );

        return $reflectionMethods;
    }

    protected function createMethod(\ReflectionMethod $reflectionMethod)
    {
        $method = new Method();
        $method->setName($reflectionMethod->getName());
        foreach ($reflectionMethod->getParameters() as $reflectionParameter) {
            $parametersName[] = $reflectionParameter->getName();
        }
        $method->setParameters($parametersName);

        return $method;
    }

    protected function getParametersFromCall($string)
    {
        $quotePattern='/"(.*?)"/';
        preg_match_all($quotePattern, $string, $matches);
        if (count($matches) < 1) {
            throw new \ErrorException(sprintf("No parameters found, please check your string call: %s", $string));
        }

        return $matches[1];
    }

    protected function guessMatch($source, $context)
    {
        $context = implode(' ', $context);
        preg_match('/.*'.$context.'.*/', $source, $matches);

        return (count($matches) > 0);
    }
}