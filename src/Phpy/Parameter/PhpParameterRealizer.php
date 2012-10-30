<?php
namespace Phpy\Parameter;

/**
 * Render a parameter to a php valid piece of code
 */
class PhpParameterRealizer implements ParameterRealizerInterface
{
    private $template = '{typeHint} {passByRef}${paramName}{defValue}';

    /**
     * @param null|string $template A template to
     */
    public function __construct($template = null)
    {
        if (isset($template))
            $this->template = $template;
    }


    /**
     * Transform a Parameter object into a valid chunk of php code for a method or function parameter definition
     * @param Parameter $parameter
     * @return mixed|void
     */
    public function render(Parameter $parameter)
    {
        $string = $this->template;

        foreach ($this->getTmplValues($parameter) as $type => $value) {
            $string = str_replace('{' . $type . '}', $value, $string);
        }

        return trim($string);
    }

    /**
     * Render the value as a default value of a php function parameter
     * @param $value
     * @throws \InvalidArgumentException
     * @return mixed|string
     */
    public function renderDefaultValue($value)
    {
        if (is_scalar($value) || is_null($value)) {
            return var_export($value, true);
        } elseif (is_array($value)) {
            $pairs = array();
            foreach ($value as $key => $subvalue) {
                $pairs[] = sprintf('%s => %s', var_export($key, true), $this->renderDefaultValue($subvalue));
            }

            return 'array(' . implode(', ', $pairs) . ')';
        } else {
            throw new \InvalidArgumentException('A default value can be only a scalar or an array');
        }
    }

    /**
     * @param Parameter $parameter
     * @return array
     */
    private function getTmplValues(Parameter $parameter)
    {
        return array(
            'typeHint' => $parameter->getTypeHint(),
            'passByRef' => $parameter->isByRef() ? '&' : '',
            'paramName' => $parameter->getName(),
            'defValue' => $parameter->hasDefaultValue()
                ? ' = ' . $this->renderDefaultValue($parameter->getDefaultValue()) : ''
        );
    }
}
