<?php
/*
 * This file is part of Phpy.
 *
 * (c) 2012 Nicolò Martini
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Phpy\Test\Method;

use Phpy\Method\Method;

/**
 * Unit tests for class Method
 *
 * @package    Phpy
 * @author     Nicolò Martini <nicmartnic@gmail.com>
 */
class MethodTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Method
     */
    protected $method;

    public function setUp()
    {
        $this->method = new Method('methodName');
    }

    public function testSetAndGetVisibility()
    {
        $this->method->setVisibility('private');

        $this->assertEquals('private', $this->method->getVisibility());
    }

    /**
     * @expectedException \OutOfBoundsException
     */
    public function testSetInvalidVisibility()
    {
        $this->method->setVisibility('hidden');
    }

    public function testIsAndGetAbstract()
    {
        $this->method->setAbstract(true);

        $this->assertTrue($this->method->isAbstract());
    }

    public function testIsAndGetStatic()
    {
        $this->method->setStatic(true);

        $this->assertTrue($this->method->isStatic());
    }

    public function testIsAndGetFinal()
    {
        $this->method->setFinal(true);

        $this->assertTrue($this->method->isFinal());
    }

    public function testMethodCannotBeFinalAndAbstractAtTheSameTime()
    {
        $this->method->setAbstract(true);

        $this->setExpectedException('BadMethodCallException');
        $this->method->setFinal(true);

        $this->method->setAbstract(false)->setFinal(true);

        $this->setExpectedException('BadMethodCallException');
        $this->method->setAbstract(true);

    }
}