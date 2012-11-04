<?php
/*
 * This file is part of Phpy.
 *
 * (c) 2012 Nicolò Martini
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Phpy\Reflection;

use Phpy\Parameter\Parameter;

/**
 * Transforms native php reflection objects to Phpy objects
 *
 * @package    Phpy
 * @author     Nicolò Martini <nicmartnic@gmail.com>
 */
class PhpyFactory extends Factory
{
    /**
     * @param \ReflectionParameter $parameter
     * @return Parameter
     */
    public function parameter(\ReflectionParameter $parameter)
    {
        $phpyParam = new Parameter($parameter->getName());

        if ($parameter->isArray()) {
            $phpyParam->setTypeHint('array');
        } elseif ($class = $parameter->getClass()) {
            $phpyParam->setTypeHint('\\' . $class->getName());
        }

        if ($parameter->isDefaultValueAvailable()) {
            $phpyParam->setDefaultValue($parameter->getDefaultValue());
        }

        $phpyParam->setByRef($parameter->isPassedByReference());

        return $phpyParam;
    }

}