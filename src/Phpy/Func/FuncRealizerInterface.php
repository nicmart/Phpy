<?php
namespace Phpy\Func;

/**
 * Interface of object that can translate a Func object into a string (presumibily valid php-code)
 */
interface FuncRealizerInterface
{
    /**
     * @param Func $function
     * @param bool $includeBody
     * @return string
     */
    public function realize(Func $function, $includeBody = true);
}