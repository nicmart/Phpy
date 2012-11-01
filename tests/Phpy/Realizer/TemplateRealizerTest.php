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

use Phpy\Realizer\TemplateRealizer;

/**
 * Unit tests for class TemplateRealizerTest
 *
 * @package    Phpy
 * @author     Nicolò Martini <nicmartnic@gmail.com>
 */
class TemplateRealizerTest extends \PHPUnit_Framework_TestCase
{
    /** @var TemplateRealizer */
    protected $realizer;

    public function setUp()
    {
        $this->realizer = new TemplateRealizer('{var1}{var2}');
    }

    public function testBasicVarSubstitution()
    {
        $this->assertEquals('xxxyyy', $this->realizer->realizeVars(array('var1' => 'xxx', 'var2' => 'yyy')));
    }

    public function testRealizeSubstituteOnlyProvidedPlaceholders()
    {
        $this->assertEquals('{var1}yyy', $this->realizer->realizeVars(array('var2' => 'yyy')));
    }

    public function testRealizerPreserveIndentsIfValueIsMultilineAndOptionIsEnabled()
    {
        $tabindent = "\t\t";
        $spaceIndent = "       ";

        $template = implode(PHP_EOL, array(
                'xxx',
                $tabindent . '{tabindented}',
                'yyy',
                $spaceIndent . '{spaceindented}',
                'kkk{spaceindented}'
        ));
        $vars = array(
            'spaceindented' => 'spaceline1' . PHP_EOL . 'spaceline2' . "\n" . 'spaceline3',
            'tabindented' => 'tabline1' . PHP_EOL . 'tabline2',
        );

        $expected = implode(PHP_EOL, array(
                'xxx',
                $tabindent . 'tabline1',
                $tabindent . 'tabline2',
                'yyy',
                $spaceIndent . 'spaceline1',
                $spaceIndent . 'spaceline2',
                $spaceIndent . 'spaceline3',
                'kkkspaceline1',
                'spaceline2',
                'spaceline3',
        ));

        $realizer = new TemplateRealizer($template);
        $realizer->setAutoIndent(true);

        $this->assertEquals($expected, $realizer->realizeVars($vars));
    }

    public function testRealizeWithouAutoindent()
    {
        $realizer = new TemplateRealizer('    {var}');
        $realizer->setAutoIndent(false);

        $value = "line1" . PHP_EOL . "line2";
        $expected = '    line1' . PHP_EOL . 'line2';

        $this->assertEquals($expected, $realizer->realizeVars(array('var' => $value)));
    }
}