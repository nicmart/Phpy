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

use Phpy\MetaClass\PhpMetaClassRealizer;
use Phpy\MetaClass\MetaClass;
use Phpy\Property\Property;
use Phpy\Method\Method;

/**
 * Unit tests for class PhpMetaClassRealizerTest
 *
 * @package    Phpy
 * @author     Nicolò Martini <nicmartnic@gmail.com>
 */
class PhpMetaClassRealizerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PhpMetaClassRealizer
     */
    protected $metaClassRealizer;

    /**
     * @var MetaClass
     */
    protected $metaClassMock;

    protected $interfaces = array('int1', 'int2');

    protected $className = 'ClassName';

    public function setUp()
    {
        $template = "";

        $methodRealizerMock = $this->getMockBuilder('Phpy\\Method\\MethodRealizerInterface')->getMock();
        $methodRealizerMock
            ->expects($this->any())
            ->method('realize')
            ->will($this->returnValue('%realizedMethod%'))
        ;
        
        $propertyRealizerMock = $this->getMockBuilder('Phpy\\Property\\PropertyRealizerInterface')->getMock();
        $propertyRealizerMock
            ->expects($this->any())
            ->method('realize')
            ->will($this->returnValue('%realizedProperty%'))
        ;

        $this->metaClassRealizer = new PhpMetaClassRealizer($template, $methodRealizerMock, $propertyRealizerMock);

        $this->metaClassMock = $this->getMockBuilder('Phpy\\MetaClass\\MetaClass')->disableOriginalConstructor()->getMock();

        $this->metaClassMock
            ->expects($this->any())
            ->method('getName')
            ->will($this->returnValue($this->className))
        ;

        $this->metaClassMock
            ->expects($this->any())
            ->method('getInterfaces')
            ->will($this->returnValue($this->interfaces))
        ;

        $this->metaClassMock
            ->expects($this->any())
            ->method('getName')
            ->will($this->returnValue($this->className))
        ;

        $this->metaClassMock
            ->expects($this->any())
            ->method('getMethods')
            ->will($this->returnValue(array(new Method('method1'), new Method('method2'), new Method('method3'))))
        ;

        $this->metaClassMock
            ->expects($this->any())
            ->method('getProperties')
            ->will($this->returnValue(array(new Property('prop1'), new Property('prop2'), new Property('prop3'))))
        ;
    }

    public function testClassNameRealization()
    {
        $this->metaClassRealizer->setDefaultTemplate('{className}');

        $this->assertEquals($this->className, $this->metaClassRealizer->realize($this->metaClassMock));
    }

    public function testExtendsRealization()
    {
        $this->metaClassRealizer->setDefaultTemplate('{extends}');

        $this->assertEquals('', $this->metaClassRealizer->realize($this->metaClassMock),
            'Realization when class does not extend another one');

        $this->metaClassMock
            ->expects($this->any())
            ->method('getParent')
            ->will($this->returnSelf())
        ;

        $this->assertEquals(' extends ClassName', $this->metaClassRealizer->realize($this->metaClassMock));
    }

    public function testImplementsRealization()
    {
        $this->metaClassRealizer->setDefaultTemplate('{interfaces}');

        $this->assertEquals(' implements int1, int2', $this->metaClassRealizer->realize($this->metaClassMock));
    }

    public function testPropertiesRealization()
    {
        $this->metaClassRealizer->setDefaultTemplate('{properties}');

        $expected = implode(';' . PHP_EOL . PHP_EOL, array_fill(0,3, '%realizedProperty%')) . ';';

        $this->assertEquals($expected, $this->metaClassRealizer->realize($this->metaClassMock));
    }

    public function testMethodsRealization()
    {
        $this->metaClassRealizer->setDefaultTemplate('{methods}');

        $expected = implode( PHP_EOL . PHP_EOL, array_fill(0,3, '%realizedMethod%'));

        $this->assertEquals($expected, $this->metaClassRealizer->realize($this->metaClassMock));
    }
}