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

use Phpy\Func\FuncRealizerInterface;
use Phpy\Method\PhpMethodRealizer;
use Phpy\Method\Method;

/**
 * Unit tests for class PhpMethodRealizer
 *
 * @package    Phpy
 * @author     Nicolò Martini <nicmartnic@gmail.com>
 */
class PhpMethodRealizerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FuncRealizerInterface
     */
    protected $funcRealizerMock;

    /**
     * @var PhpMethodRealizer
     */
    protected $methodRealizer;

    /**
     * @var Method
     */
    protected $method;

    public function setUp()
    {
        $this->funcRealizerMock = $this->getMockBuilder('Phpy\Func\FuncRealizerInterface')
            ->disableOriginalConstructor()->getMock();

        $this->funcRealizerMock
            ->expects($this->any())
            ->method('realize')
            ->will($this->returnValue('%realizedFunction%'))
        ;

        $this->methodRealizer= new PhpMethodRealizer($this->funcRealizerMock, '{modifiers} {function}');

        $this->method = new Method('methodName');
    }

    public function testRealize()
    {
        $this->method
            ->setVisibility('private')
            ->setStatic(true)
            ->setAbstract(true)
            ->setFinal(false)
        ;

        $expected = 'abstract private static %realizedFunction%';

        $this->assertEquals($expected, $this->methodRealizer->realize($this->method));
    }
}