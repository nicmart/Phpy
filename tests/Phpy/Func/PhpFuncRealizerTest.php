<?php
namespace Phpy\Test\Func;

use Phpy\Func\PhpFuncRealizer;
use Phpy\Func\Func;
use Phpy\Parameter\ParameterRealizerInterface;
use Phpy\Parameter\Parameter;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2012-10-30 at 14:19:52.
 */
class PhpFuncRealizerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PhpFuncRealizer
     */
    protected $realizer;

    /**
     * @var ParamRealizerInterface
     */
    protected $paramRealizerMock;

    /**
     * @var Func
     */
    protected $funcMock;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->paramRealizerMock = $this->getMock('\\Phpy\\Parameter\\ParameterRealizerInterface');
        $this->paramRealizerMock
            ->expects($this->any())
            ->method('realize')
            ->will($this->returnValue('xxx'))
        ;

        //This mock a func object, mocking its getParameters and getBody Method
        $this->funcMock = $this->getMockBuilder('\\Phpy\\Func\\Func')
             ->disableOriginalConstructor()
             ->getMock()

        ;
        $this->funcMock
            ->expects($this->any())
            ->method('getParameters')
            ->will($this->returnValue(array(new Parameter('a'), new Parameter('b'), new Parameter('c'))))
        ;
        $this->funcMock
            ->expects($this->any())
            ->method('getBody')
            ->will($this->returnValue('bodyMock'))
        ;

        $this->realizer = new PhpFuncRealizer($this->paramRealizerMock, 'function({parametersList}){{body}}');
    }

    /**
     * @covers Phpy\Func\PhpFuncRealizer::realize
     * @todo   Implement testRealize().
     */
    public function testRealize()
    {
        $this->assertEquals('function(xxx, xxx, xxx){bodyMock}', $this->realizer->realize($this->funcMock));
    }
}
