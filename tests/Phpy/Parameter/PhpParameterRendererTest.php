<?php
namespace Phpy\Test\Parameter;

use Phpy\Parameter\Parameter;
use Phpy\Parameter\ParameterRendererInterface;
use Phpy\Parameter\PhpParameterRenderer;

class PhpParameterRendererTest extends \PHPUnit_Framework_TestCase
{
    /** @var PhpParameterRenderer */
    protected $renderer;

    /** @var Parameter */
    protected $parameter;

    public function setUp()
    {
        $this->renderer = new PhpParameterRenderer;
        $this->parameter = new Parameter('paramName');
    }

    public function testRenderDefaultValue()
    {
        $this->assertEquals('true', $this->renderer->renderDefaultValue(true), 'Default boolean value');
        $this->assertEquals("'c\'hod'", $this->renderer->testRenderDefaultValue("c'hod"));
    }
}
