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
use Phpy\Property\Property;
use Phpy\Method\Method;
use Phpy\MetaClass\MetaClass;

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

    /**
     * @param \ReflectionMethod $method
     * @return \Phpy\Method\Method
     */
    public function method(\ReflectionMethod $method)
    {
        $phpyMethod = new Method($method->getName());

        $phpyMethod
            ->setStatic($method->isStatic())
            ->setFinal($method->isFinal())
            ->setAbstract($method->isAbstract())
        ;

        if ($method->isPublic()) {
            $phpyMethod->setVisibility('public');
        } elseif ($method->isProtected()) {
            $phpyMethod->setVisibility('protected');
        } else {
            $phpyMethod->setVisibility('private');
        }

        foreach ($method->getParameters() as $refParameter) {
            $phpyMethod->addParameter($this->parameter($refParameter));
        }

        return $phpyMethod;
    }

    /**
     * @param \ReflectionProperty $property
     * @return Property
     */
    public function property(\ReflectionProperty $property)
    {
        $phpyProperty = new Property($property->getName());

        $phpyProperty->setStatic($property->isStatic());

        $refClass = $property->getDeclaringClass();
        $defClassValues = $refClass->getDefaultProperties();

        if (isset($defClassValues[$property->getName()])) {
            $phpyProperty->setDefaultValue($defClassValues[$property->getName()]);
        }

        if ($property->isPublic()) {
            $phpyProperty->setVisibility('public');
        } elseif ($property->isProtected()) {
            $phpyProperty->setVisibility('protected');
        } else {
            $phpyProperty->setVisibility('private');
        }

        return $phpyProperty;
    }

    /**
     * @param \ReflectionClass $class
     * @return MetaClass
     */
    public function metaClass(\ReflectionClass $class)
    {
        $phpyClass = new MetaClass($class->getName());

        $phpyClass->setAbstract($class->isAbstract());

        if ($parent = $class->getParentClass()) {
            $phpyClass->setParent($this->metaClass($parent));
        }

        $phpyClass->setInterfaces($class->getInterfaceNames());

        foreach ($class->getProperties() as $refProperty) {
            $phpyClass->addProperty($this->property($refProperty));
        }

        foreach ($class->getMethods() as $refMethod) {
            $phpyClass->addMethod($this->method($refMethod));
        }

        return $phpyClass;
    }
}