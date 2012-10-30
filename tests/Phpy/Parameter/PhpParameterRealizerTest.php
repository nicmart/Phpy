<?php
namespace Phpy\Test\Parameter;

use Phpy\Parameter\Parameter;
use Phpy\Parameter\ParameterRealizerInterface;
use Phpy\Parameter\PhpParameterRealizer;

class PhpParameterRealizerTest extends \PHPUnit_Framework_TestCase
{
    /** @var PhpParameterRealizer */
    protected $renderer;

    /** @var Parameter */
    protected $parameter;

    public function setUp()
    {
        $this->renderer = new PhpParameterRealizer;
        $this->parameter = new Parameter('paramName');
    }

    public function testRenderDefaultValue()
    {
        $this->assertEquals('true', $this->renderer->renderDefaultValue(true), 'Default boolean value');
        $this->assertEquals("'c\'hod'", $this->renderer->renderDefaultValue("c'hod"), 'Default string value');
        $this->assertEquals('1234', $this->renderer->renderDefaultValue(1234), 'Default integer value');
        $this->assertEquals('1234.23', $this->renderer->renderDefaultValue(1234.23), 'Default float value');
        $this->assertEquals('NULL', $this->renderer->renderDefaultValue(null), 'Default null value');

        $ary = array('ciao' => 'mah', 'b' => array('c' => 'val'));
        $this->assertEquals(
            "array('ciao' => 'mah', 'b' => array('c' => 'val'))",
            $this->renderer->renderDefaultValue($ary),
            'Default array value'
        );
    }

    public function testRender()
    {
        $p = new Parameter('param');
        $r = $this->renderer;
        $this->assertEquals('$param', $r->render($p), 'Simple parameter');

        $p->setDefaultValue('def');
        $this->assertEquals('$param = \'def\'', $r->render($p),  'Parameter with string default value');

        $p->setByRef(true);
        $this->assertEquals('&$param = \'def\'', $r->render($p), 'Parameter with string default value and passed by ref');

        $p = new Parameter('param');
        $p->setTypeHint('stdClass');
        $this->assertEquals('stdClass $param', $r->render($p), 'Parameter with Type Hinting');
    }
}
