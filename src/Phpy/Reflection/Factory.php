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
use Phpy\Func\Func;
use Phpy\Method\Method;
use Phpy\Property\Property;
use Phpy\MetaClass\MetaClass;

/**
 * This is the type of factories that converts native PHP Reflection objects
 * to Phpy objects
 *
 * @package    Phpy
 * @author     Nicolò Martini <nicmartnic@gmail.com>
 */
abstract class Factory
{
    /**
     * @param \ReflectionProperty $property
     * @return Property
     */
    //abstract public function property(\ReflectionProperty $property);

    /**
     * @param \ReflectionParameter $parameter
     * @return Parameter
     */
    abstract public function parameter(\ReflectionParameter $parameter);

    /**
     * @param \ReflectionMethod $method
     * @return Method
     */
    abstract public function method(\ReflectionMethod $method);

    /**
     * @param \ReflectionProperty $prop
     * @return Property
     */
    abstract public function property(\ReflectionProperty $prop);

    /**
     * @param \ReflectionClass $class
     * @return MetaClass
     */
    abstract public function metaClass(\ReflectionClass $class);
}