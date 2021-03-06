<?php
/**
 * This file is part of the Talker Texas Ranger package.
 *
 * (c) 2015 Nicola Pietroluongo <nik.longstone@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Talker;

use Talker\Parser\CamelCaseParser;
use Talker\Parser\DoubleQuotesParser;
use Talker\Parser\ResourceParserInterface;

/**
 * Class Talker.
 * Will allow to use natural language to call every methods a given resource class.
 */
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

    /**
     * Constructor.
     *
     * @param object                    $resource
     * @param ResourceInterface|null    $methodNameParser
     * @param ResourceInterface|null    $inputParser
     *
     * @throws \ErrorException
     * @throws \Exception
     */
    public function __construct($resource, $methodNameParser = null, $inputParser = null)
    {
        try {
            get_class($resource);
        }catch(\Exception $e){
            throw new \ErrorException("The class defined doesn't exists");
        }
        $this->setDefaultParser($methodNameParser, $inputParser);
        $this->resource = $resource;
        $this->resourceMethods = $this->getMethods($resource);
    }

    /**
     * Calls the method with natural language.
     *
     * @param string $phrase
     *
     * @return bool
     * @throws \ErrorException
     */
    public function call($phrase)
    {
        foreach ($this->resourceMethods as $method) {

            return $this->runTheMethodForTheGivenPhrase($method, $phrase);
        }

        throw new \ErrorException(sprintf('No method found for the given phrase:"%s"', $phrase));
    }

    /**
     * Sets default parsers.
     *
     * @param ResourceParserInterface|null $methodNameParser
     * @param ResourceParserInterface|null $inputParser
     */
    private function setDefaultParser($methodNameParser, $inputParser)
    {
        if (!$methodNameParser instanceof ResourceParserInterface) {
            $this->parser = new CamelCaseParser();
        }
        if (!$inputParser instanceof ResourceParserInterface) {
            $this->inputParser = new DoubleQuotesParser();
        }
    }

    /**
     * Runs the Class method according to the given phrase
     *
     * @param Method    $method
     * @param string    $phrase
     *
     * @return bool
     *
     * @throws \ErrorException
     */
    private function runTheMethodForTheGivenPhrase(Method $method, $phrase)
    {
        $parsedMethod = $this->parser->parse($method->getName());
        if ($this->guessMatch($phrase, $parsedMethod)) {
            $parameters = $this->inputParser->parse($phrase);

            return $this->runMethod($method, $parameters);
        }

        throw new \ErrorException(sprintf('No method found for the given phrase:"%s"', $phrase));
    }

    /**
     * Performs the method call.
     *
     * @param Method    $method
     * @param array     $parameters
     *
     * @return bool
     */
    private function runMethod(Method $method, array $parameters)
    {
        call_user_func_array(array($this->resource, $method->getName()), $parameters);

        return true;
    }

    /**
     * Returns an array of Methods.
     *
     * @param object $resource
     *
     * @return array
     */
    private function getMethods($resource)
    {
        $reflection = new \ReflectionClass($resource);

        return $this->getMethodsList($reflection->getMethods());
    }

    /**
     * Iterates on every ReflectionMethods to create Methods.
     *
     * @param \ReflectionMethod $reflectionMethods
     *
     * @return array
     */
    private function getMethodsList($reflectionMethods)
    {
        array_walk(
            $reflectionMethods,
            function (&$v) {
                $v = $this->createMethod($v);
            }
        );

        return $reflectionMethods;
    }

    /**
     * Creates a Method class.
     *
     * @param \ReflectionMethod $reflectionMethod
     *
     * @return Method
     */
    private function createMethod(\ReflectionMethod $reflectionMethod)
    {
        $methodName = $reflectionMethod->getName();
        foreach ($reflectionMethod->getParameters() as $reflectionParameter) {
            $parametersName[] = $reflectionParameter->getName();
        }

        return new Method($methodName, $parametersName);;
    }

    /**
     * Returns a match if the $context is in the $source.
     *
     * @param string $source
     * @param array  $context
     *
     * @return bool
     */
    private function guessMatch($source, array $context)
    {
        $context = implode(' ', $context);
        preg_match('/.*'.$context.'.*/', $source, $matches);

        return (count($matches) > 0);
    }
}