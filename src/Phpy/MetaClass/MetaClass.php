<?php
/*
 * This file is part of Phpy.
 *
 * (c) 2012 Nicolò Martini
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Phpy\MetaClass;

use Phpy\Property\Property;
use Phpy\Method\Method;

/**
 * Class Description
 *
 * @package    Phpy
 * @author     Nicolò Martini <nicmartnic@gmail.com>
 */
class MetaClass
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $namespace;

    /**
     * @var MetaClass
     */
    private $parent;

    /**
     * @var bool
     */
    private $isAbstract;

    /**
     * @var array
     */
    private $interfaces = array();

    /**
     * An array of Parameter objects
     * @var array
     */
    private $properties = array();

    /**
     * An array of Method objects
     * @var array
     */
    private $methods = array();

    /**
     * @param string $name The name of the class
     * @param MetaClass $parent
     * @param array $interfaces
     */
    public function __construct($name, MetaClass $parent = null, $interfaces = array())
    {
        $pieces = explode('\\', $name);
        $realName = array_pop($pieces);

        $this->setName($realName);

        if (count($pieces)) {
            $this->setNamespace(implode('\\', $pieces));
        }

        if (isset($parent))
            $this->setParent($parent);

        $this->setInterfaces($interfaces);
    }

    /**
     * Set The name of the class
     *
     * @param string $name
     *
     * @return MetaClass The current instance
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get the name of the class
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * The full name of the class, namespace included
     *
     * @return string
     */
    public function getFullQualifiedName()
    {
        return $this->getNamespace() . '\\' . $this->getName();
    }

    /**
     * Set Namespace
     *
     * @param string $namespace
     *
     * @return MetaClass The current instance
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
        return $this;
    }

    /**
     * Get Namespace
     *
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Set Parent
     *
     * @param MetaClass $parent
     *
     * @return MetaClass The current instance
     */
    public function setParent(MetaClass $parent)
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * Get Parent
     *
     * @return MetaClass
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set Abstract
     *
     * @param boolean $abstract
     *
     * @return MetaClass The current instance
     */
    public function setAbstract($abstract)
    {
        $this->isAbstract = (bool) $abstract;

        return $this;
    }

    /**
     * Is the class Abstract?
     *
     * @return boolean
     */
    public function isAbstract()
    {
        return $this->isAbstract;
    }

    /**
     * Set Interfaces
     *
     * @param array $interfaces
     *
     * @return MetaClass The current instance
     */
    public function setInterfaces(array $interfaces)
    {
        $this->interfaces = $interfaces;
        return $this;
    }

    /**
     * Get Interfaces
     *
     * @return array
     */
    public function getInterfaces()
    {
        return $this->interfaces;
    }

    /**
     * The class implements the interface $interfaceName?
     *
     * @param $interfaceName
     * @return bool
     */
    public function implementsInterface($interfaceName)
    {
        return in_array($interfaceName, $this->getInterfaces());
    }

    /**
     * Add an interface to the class
     *
     * @param string $interfaceName
     * @return MetaClass The current instance
     */
    public function addInterface($interfaceName)
    {
        if (!$this->implementsInterface($interfaceName))
            $this->interfaces[] = $interfaceName;

        return $this;
    }

    /**
     * Remove an interface from the class
     *
     * @param string $interfaceName
     * @return MetaClass The current instance
     */
    public function removeInterface($interfaceName)
    {
        $index = array_search($interfaceName, $this->interfaces);

        if ($index !== false)
            unset($this->interfaces[$index]);

        return $this;
    }

    /**
     * Set Properties
     *
     * @param array $properties
     *
     * @return MetaClass The current instance
     */
    public function setProperties(array $properties)
    {
        foreach ($properties as $property) {
            $this->addProperty($property);
        }

        return $this;
    }

    /**
     * Get Properties
     *
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * Add a property to the class
     *
     * @param Property $property
     * @throws \InvalidArgumentException
     * @return MetaClass The current instance
     */
    public function addProperty(Property $property)
    {
        if ($this->hasProperty($property->getName()))
            throw new \InvalidArgumentException('Class already has a property named ' . $property->getName());

        $this->properties[] = $property;

        return $this;
    }

    /**
     * The class has a property named $propertyName?
     *
     * @param string $propertyName
     *
     * @return bool
     */
    public function hasProperty($propertyName)
    {
        foreach ($this->getProperties() as $property) {
            if ($property->getName() == $propertyName)
                return true;
        }

        return false;
    }

    /**
     * Returns a property by its name
     *
     * @param string $propertyName
     * @return Property
     * @throws \InvalidArgumentException
     */
    public function getProperty($propertyName)
    {
        foreach ($this->getProperties() as $prop) {
            if ($prop->getName() == $propertyName)
                return $prop;
        }

        throw new \InvalidArgumentException(sprintf('The class has not a property named %s', $propertyName));
    }

    /**
     * @param string $propertyName
     * @return MetaClass The current instance
     */
    public function removeProperty($propertyName)
    {
        foreach ($this->properties as $index => $property) {
            if ($property->getName() == $propertyName) {
                unset($this->properties[$index]);
                break;
            }
        }

        return $this;
    }
    
    /**
     * Set Methods
     *
     * @param array $methods
     *
     * @return MetaClass The current instance
     */
    public function setMethods(array $methods)
    {
        foreach ($methods as $method) {
            $this->addMethod($method);
        }

        return $this;
    }

    /**
     * Get Methods
     *
     * @return array
     */
    public function getMethods()
    {
        return $this->methods;
    }

    /**
     * Add a method to the class
     *
     * @param Method $method
     * @throws \InvalidArgumentException
     * @return MetaClass The current instance
     */
    public function addMethod(Method $method)
    {
        if ($this->hasMethod($method->getName()))
            throw new \InvalidArgumentException('Class already has a method named ' . $method->getName());

        $this->methods[] = $method;

        return $this;
    }

    /**
     * The class has a method named $methodName?
     *
     * @param string $methodName
     *
     * @return bool
     */
    public function hasMethod($methodName)
    {
        foreach ($this->getMethods() as $method) {
            if ($method->getName() == $methodName)
                return true;
        }

        return false;
    }

    /**
     * Returns a method by its name
     *
     * @param string $methodName
     * @return Method
     * @throws \InvalidArgumentException
     */
    public function getMethod($methodName)
    {
        foreach ($this->getMethods() as $method) {
            if ($method->getName() == $methodName)
                return $method;
        }

        throw new \InvalidArgumentException(sprintf('The class has not a method named %s', $methodName));
    }

    /**
     * @param string $methodName
     * @return MetaClass The current instance
     */
    public function removeMethod($methodName)
    {
        foreach ($this->methods as $index => $method) {
            if ($method->getName() == $methodName) {
                unset($this->methods[$index]);
                break;
            }
        }

        return $this;
    }
}