<?php
/*
 * This file is part of Phpy.
 *
 * (c) 2012 Nicolò Martini
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Phpy\Test;

use Phpy\Property\Property;

/**
 * Unit tests for class PropertyTest
 *
 * @package    Phpy
 * @author     Nicolò Martini <nicmartnic@gmail.com>
 */
class PropertyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Property
     */
    protected $property;

    public function setUp()
    {
        $this->property = new Property('prop');
    }

    public function testGetAndSetName()
    {
        $this->property->setName('xxx');

        $this->assertEquals('xxx', $this->property->getName());
    }

    public function testGetAndIsStatic()
    {
        $this->property->setStatic(true);

        $this->assertTrue($this->property->isStatic());
    }

    /**
     * @expectedException \OutOfBoundsException
     */
    public function testSetInvalidVisibility()
    {
        $this->property->setVisibility('xxx');
    }

    public function testSetAndGetDefalutValue()
    {
        $this->property->setDefaultValue('xxx');

        $this->assertEquals('xxx', $this->property->getDefaultValue());
    }

    public function testAfterSettingDefaultValueHasDefaultValueReturnsTrue()
    {
        $this->property->setDefaultValue('xxx');

        $this->assertTrue($this->property->hasDefaultValue());
    }

    public function testAfterRemovingDefaultValueHasDefaultValueReturnsFalse()
    {
        $this->property->setDefaultValue('xxx')->removeDefaultValue();

        $this->assertFalse($this->property->hasDefaultValue());
    }
}