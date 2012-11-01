<?php
namespace Phpy\Test\Parameter;

use Phpy\Parameter\Parameter;
use Phpy\Parameter\ParameterRealizerInterface;
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
        $this->parameter = new Parameter('paramName');
    }

    public function testRenderDefaultValue()
    {
        $this->assertEquals('true', $this->realizer->renderDefaultValue(true), 'Default boolean value');
        $this->assertEquals("'c\'hod'", $this->realizer->renderDefaultValue("c'hod"), 'Default string value');
        $this->assertEquals('1234', $this->realizer->renderDefaultValue(1234), 'Default integer value');
        $this->assertEquals('1234.23', $this->realizer->renderDefaultValue(1234.23), 'Default float value');
        $this->assertEquals('NULL', $this->realizer->renderDefaultValue(null), 'Default null value');

        $ary = array('ciao' => 'mah', 'b' => array('c' => 'val'));
        $this->assertEquals(
            "array('ciao' => 'mah', 'b' => array('c' => 'val'))",
            $this->realizer->renderDefaultValue($ary),
            'Default array value'
        );
    }

    public function testRender()
    {
        $p = new Parameter('param');
        $r = $this->realizer;
        $this->assertEquals('$param', $r->realize($p), 'Simple parameter');

        $p->setDefaultValue('def');
        $this->assertEquals('$param = \'def\'', $r->realize($p),  'Parameter with string default value');

        $p->setByRef(true);
        $this->assertEquals('&$param = \'def\'', $r->realize($p), 'Parameter with string default value and passed by ref');

        $p = new Parameter('param');
        $p->setTypeHint('stdClass');
        $this->assertEquals('stdClass $param', $r->realize($p), 'Parameter with Type Hinting');
    }
}
