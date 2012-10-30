<?php
namespace Phpy\Parameter;

interface ParameterRealizerInterface
{
    /**
     * Transform a parameter object into something else
     *
     * @param Parameter $parameter
     * @return mixed
     */
    public function render(Parameter $parameter);
}