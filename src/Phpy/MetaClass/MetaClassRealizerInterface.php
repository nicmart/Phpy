<?php
/*
 * This file is part of Phpy.
 *
 * (c) 2012 Nicolò Martini
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Phpy\MetaClass;

/**
 * Realizers of MetaClasses
 *
 * @package    Phpy
 * @author     Nicolò Martini <nicmartnic@gmail.com>
 */
interface MetaClassRealizerInterface
{
    /**
     * @param MetaClass $class
     * @return mixed
     */
    public function realize(MetaClass $class);
}