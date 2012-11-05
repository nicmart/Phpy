<?php
/*
 * This file is part of Phpy.
 *
 * (c) 2012 Nicolò Martini
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Phpy\Test\PhpyNamespace;

use Phpy\PhpyNamespace\PhpyNamespace;

/**
 * Unit tests for class PhpyNamespace
 *
 * @package    Phpy
 * @author     Nicolò Martini <nicmartnic@gmail.com>
 */
class PhpyNamespaceTest extends \PHPUnit_Framework_TestCase
{
    /** @var PhpyNamespace */
    protected $ns;

    public function setUp()
    {
        $this->ns = new PhpyNamespace();
    }

    public function testEmptyConstructorBuildGlobalNamespace()
    {
        $this->assertEquals('\\', $this->ns->getNamespace());
    }

    public function testSetAndGetNamespace()
    {
        $this->ns->setNamespace('\\A\\B\\C');

        $this->assertEquals('\\A\\B\\C', $this->ns->getNamespace());

        $this->ns->setNamespace('A\\B\\C');
        $this->assertEquals('\\A\\B\\C', $this->ns->getNamespace(), 'Not Absolute namespaces are considered in the global namespace');
    }

    public function testGetCommonAncestor()
    {
        $this->ns->setNamespace('\\A\\B\\C\\D\\E');
        $ns2 = new PhpyNamespace('\\A\\B\\F\\G');
        $ns3 = new PhpyNamespace('C\\A\\F');

        $this->assertEquals('\\A\\B', $this->ns->getCommonAncestor($ns2)->getNamespace());
        $this->assertEquals('\\', $this->ns->getCommonAncestor($ns3)->getNamespace());
    }
}