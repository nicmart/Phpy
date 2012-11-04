<?php
/*
 * This file is part of Phpy.
 *
 * (c) 2012 Nicolò Martini
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Phpy\Test\Reflection;

use Phpy\Reflection\PhpyFactory;
use Phpy\MetaClass\MetaClass;

/**
 * Unit tests for class PhpyFactoryTest
 *
 * @package    Phpy
 * @author     Nicolò Martini <nicmartnic@gmail.com>
 */
class PhpyFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PhpyFactory
     */
    protected $factory;

    /**
     * An array of reflection parameters
     * @var array
     */
    protected $refParams = array();
    protected $phpyParams = array();

    protected $refMethods = array();
    protected $phpyMethods = array();

    protected $refProps = array();
    protected $phpyProps = array();

    /**
     * @var \ReflectionClass
     */
    protected $refClass;

    /**
     * @var MetaClass
     */
    protected $phpyClass;

    /**
     * @var MetaClass
     */
    protected $phpyExtendedClass;

    public function setUp()
    {
        $this->factory = new PhpyFactory;

        $refFunction = new \ReflectionFunction('Phpy\\Test\\Reflection\\dummyFunction');

        $this->refParams = $refFunction->getParameters();

        foreach ($this->refParams as $refParam) {
            $this->phpyParams[] = $this->factory->parameter($refParam);
        }

        $this->refClass = new \ReflectionClass('Phpy\\Test\\Reflection\\DummyClass');

        $this->refMethods = $this->refClass->getMethods();
        foreach ($this->refMethods as $refMethod) {
            $this->phpyMethods[] = $this->factory->method($refMethod);
        }

        $this->refProps = $this->refClass->getProperties();
        foreach ($this->refProps as $refProp) {
            $this->phpyProps[] = $this->factory->property($refProp);
        }

        $this->phpyClass = $this->factory->metaClass($this->refClass);

        $this->phpyExtendedClass = $this->factory->metaClass(new \ReflectionClass('Phpy\\Test\\Reflection\\ExtensionClass'));

    }

    public function testParam()
    {
        $phpyParams = $this->phpyParams;

        $this->assertEquals('var0', $phpyParams[0]->getName());

        $this->assertTrue($phpyParams[1]->isByRef());

        $this->assertEquals('array', $phpyParams[2]->getTypeHint());

        $this->assertEquals('\SplObjectStorage', $phpyParams[3]->getTypeHint());

        $this->assertTrue($phpyParams[4]->hasDefaultValue());
        $this->assertEquals('default', $phpyParams[4]->getDefaultValue());
    }

    public function testMethod()
    {
        $phpyMethods = $this->phpyMethods;

        $this->assertEquals('method0', $phpyMethods[0]->getName());
        $this->assertTrue($phpyMethods[0]->isStatic());
        $this->assertEquals('public', $phpyMethods[0]->getVisibility());

        $params = $phpyMethods[0]->getParameters();
        $this->assertEquals('var0', $params[0]->getName());
        $this->assertEquals('mah', $params[1]->getDefaultValue());

        $this->assertEquals('private', $phpyMethods[1]->getVisibility());

        $this->assertTrue($phpyMethods[2]->isAbstract());

        $this->assertTrue($phpyMethods[3]->isFinal());
    }

    public function testProperty()
    {
        $phpyProps = $this->phpyProps;

        $this->assertEquals('prop0', $phpyProps[0]->getName());
        $this->assertEquals('public', $phpyProps[0]->getVisibility());
        $this->assertTrue($phpyProps[0]->isStatic());

        $this->assertEquals('prop1', $phpyProps[1]->getName());
        $this->assertEquals('private', $phpyProps[1]->getVisibility());

        $this->assertEquals('prop2', $phpyProps[2]->getName());
        $this->assertEquals('protected', $phpyProps[2]->getVisibility());
        $this->assertEquals('default', $phpyProps[2]->getDefaultValue());
    }

    public function testMetaClass()
    {
        $class = $this->phpyClass;
        $props = $this->phpyClass->getProperties();
        $methods = $this->phpyClass->getMethods();

        $this->assertEquals('DummyClass', $class->getName());
        $this->assertTrue($class->isAbstract());
        $this->assertEquals('Phpy\\Test\\Reflection', $class->getNamespace());

        $this->assertTrue($class->implementsInterface('Phpy\\Test\\Reflection\\DummyInterface'));

        $this->assertEquals($props, $this->phpyProps);
        $this->assertEquals($methods, $this->phpyMethods);

        $this->assertEquals('stdClass', $this->phpyExtendedClass->getParent()->getName());
    }
}

function dummyFunction($var0, &$var1, array $var2, \SplObjectStorage $var3, $var4 = 'default') {

}

interface DummyInterface {

}

abstract class DummyClass implements DummyInterface
{
    public static $prop0;
    private $prop1;
    protected $prop2 = 'default';

    public static function method0($var0, $var1 = 'mah') {

    }

    private function method1()
    {

    }

    abstract function method2();

    final function method3() {

    }
}

class ExtensionClass extends \stdClass
{

}