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
}