<?php
/*
 * This file is part of Phpy.
 *
 * (c) 2012 Nicolò Martini
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Phpy\Property;

/**
 * Property realizers
 *
 * @package    Phpy
 * @author     Nicolò Martini <nicmartnic@gmail.com>
 */
interface PropertyRealizerInterface
{
    /**
     * Realize a Property object in a valid php class property declaration
     * @param Property $property
     * @return string
     */
    public function realize(Property $property);
}