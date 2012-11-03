<?php
/*
 * This file is part of Phpy.
 *
 * (c) 2012 Nicolò Martini
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Phpy\Test\MetaClass;

use Phpy\MetaClass\MetaClass;
use Phpy\Property\Property;
use Phpy\Method\Method;

/**
 * Unit tests for class MetaClassTest
 *
 * @package    Phpy
 * @author     Nicolò Martini <nicmartnic@gmail.com>
 */
class MetaClassTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MetaClass
     */
    protected $class;

    public function setUp()
    {
        $this->class = new MetaClass('MyClass');
    }

    public function testSetAndGetName()
    {
        $name = 'xyz';
        $this->class->setName($name);
        $this->assertEquals($name, $this->class->getName());
    }

    public function testSetAndgetNamespace()
    {
        $ns = 'ABC\\DEF';

        $this->assertEquals($ns, $this->class->setNamespace($ns)->getNamespace());
    }

    public function testGetFullQualifiedNamespace()
    {
        $ns = 'ABC\\DEF';
        $this->class->setNamespace($ns);

        $this->assertEquals($ns . '\\MyClass', $this->class->getFullQualifiedName());
    }

    public function testInterfacesMethods()
    {
        $interfaces = array('interface1', 'interface2', 'interface3');

        $this->class->setInterfaces($interfaces);

        $this->assertEquals($interfaces, $this->class->getInterfaces(), 'Get interface should return previously set interfaces');

        $this->class->addInterface('interface4');

        $this->assertEquals(array_merge($interfaces, array('interface4')), $this->class->getInterfaces());

        $this->class->removeInterface('interface2');

        $this->assertEquals(array('interface1', 'interface3', 'interface4'), array_values($this->class->getInterfaces()));
    }

    public function testPropertiesMethods()
    {
        $properties = array($prop1 = new Property('prop1'), $prop2 = new Property('prop2'), $prop3 = new Property('prop3'));

        $this->class->setProperties($properties);

        $this->assertEquals($properties, $this->class->getProperties(), 'Set And Get Properties test');

        $this->class->addProperty($prop4 = new Property('prop4'));

        $this->assertEquals(array($prop1, $prop2, $prop3, $prop4), $this->class->getProperties(), 'AddProperty method test');

        $this->class->removeProperty('prop2');

        $this->assertEquals(array($prop1, $prop3, $prop4), \array_values($this->class->getProperties()), 'Remove property test');

        $this->assertEquals($this->class->getProperty('prop1'), $prop1, 'GetProperty Test');

        $this->setExpectedException('InvalidArgumentException');

        $this->class->getProperty('prop2');
    }
    
    public function testMethodsMethods()
    {
        $methods = array($method1 = new Method('method1'), $method2 = new Method('method2'), $method3 = new Method('method3'));

        $this->class->setMethods($methods);

        $this->assertEquals($methods, $this->class->getMethods(), 'Set And Get Methods test');

        $this->class->addMethod($method4 = new Method('method4'));

        $this->assertEquals(array($method1, $method2, $method3, $method4), $this->class->getMethods(), 'AddMethod method test');

        $this->class->removeMethod('method2');

        $this->assertEquals(array($method1, $method3, $method4), \array_values($this->class->getMethods()), 'Remove method test');

        $this->assertEquals($this->class->getMethod('method1'), $method1, 'GetMethod Test');

        $this->setExpectedException('InvalidArgumentException');

        $this->class->getMethod('method2');
    }
}