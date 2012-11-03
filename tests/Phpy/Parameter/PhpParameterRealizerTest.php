<?php
namespace Phpy\Test\Parameter;

use Phpy\Parameter\Parameter;
use Phpy\Parameter\PhpParameterRealizer;

class PhpParameterRealizerTest extends \PHPUnit_Framework_TestCase
{
    /** @var PhpParameterRealizer */
    protected $realizer;

    /** @var Parameter */
    protected $parameter;

    public function setUp()
    {
        $this->realizer = new PhpParameterRealizer;

        $valueRealizerMock = $this->getMockBuilder('Phpy\Realizer\ValueRealizerInterface')->getMock();

        $valueRealizerMock->expects($this->any())
            ->method('realizeValue')
            ->will($this->returnValue('mockedDefValue'))
        ;

        $this->realizer->setValueRealizer($valueRealizerMock);

        $this->parameter = new Parameter('paramName');
    }

    public function testRender()
    {
        $p = new Parameter('param');
        $r = $this->realizer;
        $this->assertEquals('$param', $r->realize($p), 'Simple parameter');

        $p->setDefaultValue('def');
        $this->assertEquals('$param = mockedDefValue', $r->realize($p),  'Parameter with string default value');

        $p->setByRef(true);
        $this->assertEquals('&$param = mockedDefValue', $r->realize($p), 'Parameter with string default value and passed by ref');

        $p = new Parameter('param');
        $p->setTypeHint('stdClass');
        $this->assertEquals('stdClass $param', $r->realize($p), 'Parameter with Type Hinting');
    }
}
