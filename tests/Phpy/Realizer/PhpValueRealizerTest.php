<?php
/*
 * This file is part of Phpy.
 *
 * (c) 2012 Nicolò Martini
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Phpy\Test\Realizer;

use Phpy\Realizer\PhpValueRealizer;

/**
 * Unit tests for class PhpValueRealizerTest
 *
 * @package    Phpy
 * @author     Nicolò Martini <nicmartnic@gmail.com>
 */
class PhpValueRealizerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PhpValueRealizer
     */
    protected $realizer;

    public function setUp()
    {
        $this->realizer = new PhpValueRealizer;
    }

    public function testRealizeANullValue()
    {
        $this->assertEquals('null', $this->realizer->realizeValue(null));
    }

    public function testRealizeAnInteger()
    {
        $this->assertEquals('351', $this->realizer->realizeValue(351));
    }

    public function testRealizeAFloat()
    {
        $this->assertEquals('3.17', $this->realizer->realizeValue(3.17));
    }

    public function testRealizeABoolean()
    {
        $this->assertEquals('true', $this->realizer->realizeValue(true));
        $this->assertEquals('false', $this->realizer->realizeValue(false));
    }

    public function testRealizeAString()
    {
        $string = 'hello \'world\'!!! "quoted"';
        $expected = "'hello \\'world\\'!!! \"quoted\"'";

        $this->assertEquals($expected, $this->realizer->realizeValue($string));
    }

    public function testRealizeArray()
    {
        $ary = array('a' => 'b', 'c' => 'd', 'e' => array('1' => 123, 2 => true, 'ciao' => 2.12));

        //Note: string keys of php-array that are string representation of integers are automatically converted to
        //integers
        $expected = "array('a' => 'b', 'c' => 'd', 'e' => array(1 => 123, 2 => true, 'ciao' => 2.12))";

        $this->assertEquals($expected, $this->realizer->realizeValue($ary));
    }
}