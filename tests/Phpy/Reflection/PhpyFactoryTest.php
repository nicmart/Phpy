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

    public function setUp()
    {
        $this->factory = new PhpyFactory;

        $refFunction = new \ReflectionFunction('Phpy\\Test\\Reflection\\dummyFunction');

        $this->refParams = $refFunction->getParameters();
    }

    public function testFirstTest()
    {
        $phpyParams = array();

        foreach ($this->refParams as $refParam) {
            $phpyParams[] = $this->factory->parameter($refParam);
        }

        $this->assertEquals('var0', $phpyParams[0]->getName());

        $this->assertTrue($phpyParams[1]->isByRef());

        $this->assertEquals('array', $phpyParams[2]->getTypeHint());

        $this->assertEquals('\SplObjectStorage', $phpyParams[3]->getTypeHint());

        $this->assertTrue($phpyParams[4]->hasDefaultValue());
        $this->assertEquals('default', $phpyParams[4]->getDefaultValue());
    }
}

function dummyFunction($var0, &$var1, array $var2, \SplObjectStorage $var3, $var4 = 'default') {

}