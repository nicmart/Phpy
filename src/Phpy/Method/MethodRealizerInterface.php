<?php
/*
 * This file is part of Phpy.
 *
 * (c) 2012 Nicolò Martini
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Phpy\Method;

/**
 * Interface for Method renderers
 *
 * @package    Phpy
 * @author     Nicolò Martini <nicmartnic@gmail.com>
 */
interface MethodRealizerInterface
{
    /**
     * @param Method $method
     * @return mixed
     */
    public function realize(Method $method);
}