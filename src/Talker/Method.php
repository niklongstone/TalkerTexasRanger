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

/**
 * Class Method.
 *
 * Is a class method representation.
 */
final class Method
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $parameters;

    /**
     * Constructor.
     *
     * @param string $name
     * @param array  $parameters
     */
    public function __construct($name, array $parameters)
    {
        $this->name = $name;
        $this->parameters = $parameters;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }
}