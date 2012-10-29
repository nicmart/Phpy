<?php
namespace Phpy\Test\Func;

use Phpy\Func\Func;
use Phpy\Parameter\Parameter;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2012-10-29 at 09:45:14.
 */
class FuncTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Func
     */
    protected $func;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->func = new Func('foo');
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers Phpy\Func\Func::setNamespace
     * @covers Phpy\Func\Func::getNamespace
     */
    public function testSetAndGetNamespace()
    {
        $ns = 'asdasd\\asdsd';
        $this->func->setNamespace($ns);

        $this->assertEquals($ns, $this->func->getNamespace());
    }

    public function testConstructorSetAutomaticallyTheNamespace()
    {
        $func = new Func('Hello\\World\\Function');

        $this->assertEquals('Hello\\World', $func->getNamespace());
        $this->assertEquals('Function', $func->getName());
    }

    /**
     * @covers Phpy\Func\Func::setName
     * @covers Phpy\Func\Func::getName
     */
    public function testSetAndGetName()
    {
        $name = 'bar';
        $this->func->setName($name);

        $this->assertEquals($name, $this->func->getName());
    }

    /**
     * @covers Phpy\Func\Func::getFullQualifiedName
     */
    public function testGetFullQualifiedName()
    {
        $this->func->setName('foo')->setNamespace('a\\b');

        $this->assertEquals('a\\b\\foo', $this->func->getFullQualifiedName());
    }

    /**
     * @covers Phpy\Func\Func::setParameters
     * @covers Phpy\Func\Func::getParameters
     */
    public function testSetAndGetParameters()
    {
        $params = array(new Parameter('ciao'), new Parameter('bau'));
        $this->func->setParameters($params);
        $this->assertEquals($params, $this->func->getParameters());
    }

    /**
     * @covers Phpy\Func\Func::addParameter
     */
    public function testAddParameter()
    {
        $param1 = new Parameter('p1');
        $param2 = new Parameter('p2');

        $this->func
            ->addParameter($param1)
            ->addParameter($param2)
        ;

        $this->assertEquals(array($param1, $param2), $this->func->getParameters());
    }

    /**
     * @covers Phpy\Func\Func::setBody
     * @covers Phpy\Func\Func::getBody
     */
    public function testSetAndGetBody()
    {
        $body = 'asdasd xxx ; xasd';

        $this->func->setBody($body);

        $this->assertEquals($body, $this->func->getBody());
    }
}