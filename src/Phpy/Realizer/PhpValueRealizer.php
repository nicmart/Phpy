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
 * This class transform a php-value (a scalar, a null value or an array) to valid php-code
 *
 * @package    Phpy
 * @author     Nicolò Martini <nicmartnic@gmail.com>
 */
class PhpValueRealizer implements ValueRealizerInterface
{
    /**
     * Realize the given value in valid php code
     *
     * @param $value
     * @throws \InvalidArgumentException
     * @return mixed
     */
    public function realizeValue($value)
    {
        if (is_null($value)) {
            //We do not use var_export here because it would return "NULL"... :)
            return 'null';
        } elseif (is_scalar($value)) {
            return var_export($value, true);
        } elseif (is_array($value)) {
            $pairs = array();
            foreach ($value as $key => $subvalue) {
                $pairs[] = sprintf('%s => %s', var_export($key, true), $this->realizeValue($subvalue));
            }

            return 'array(' . implode(', ', $pairs) . ')';
        } else {
            throw new \InvalidArgumentException('Realizable objects are scalar, null values, and array of realizable objects');
        }
    }
}