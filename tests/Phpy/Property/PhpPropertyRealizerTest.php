<?php
/*
 * This file is part of Phpy.
 *
 * (c) 2012 Nicolò Martini
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Phpy\Test\Property;

use Phpy\Property\Property;
use Phpy\Property\PhpPropertyRealizer;

/**
 * Unit tests for class PhpPropertyRealizerTest
 *
 * @package    Phpy
 * @author     Nicolò Martini <nicmartnic@gmail.com>
 */
class PhpPropertyRealizerTest extends \PHPUnit_Framework_TestCase
{
    /** @var PhpPropertyRealizer */
    protected $realizer;

    /** @var Property */
    protected $property;

    public function setUp()
    {
        $this->realizer = new PhpPropertyRealizer('{modifiers} ${propName}{defValue}');
        $this->property = new Property('prop');
    }

    public function testRealize()
    {
        $this->property
            ->setVisibility('private')
            ->setStatic(true)
        ;

        $this->assertEquals('private static $prop', $this->realizer->realize($this->property));

        $this->property->setDefaultValue('default');
        $this->assertEquals('private static $prop = \'default\'', $this->realizer->realize($this->property),
            'Realization with sting default value');

        $this->property->setDefaultValue(12.21);
        $this->assertEquals('private static $prop = 12.21', $this->realizer->realize($this->property),
            'Realization with float default value');

        $this->property->setDefaultValue(array('c' => 'a', 'd' => 'f'));

        $this->assertEquals("private static \$prop = array('c' => 'a', 'd' => 'f')", $this->realizer->realize($this->property),
            'Realization with array default value');
    }
}