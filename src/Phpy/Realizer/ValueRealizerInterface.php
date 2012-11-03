<?php
/*
 * This file is part of Phpy.
 *
 * (c) 2012 Nicolò Martini
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phpy\Realizer;

/**
 * Interface of objects that can transform a value to valid php-code
 */
interface ValueRealizerInterface
{
    /**
     * Realize the given value in valid php code
     *
     * @param $value
     * @return mixed
     */
    public function realizeValue($value);
}
