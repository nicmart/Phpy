<?php
namespace Phpy\Parameter;

use Phpy\Realizer\TemplateRealizer;

/**
 * Render a parameter to a php valid piece of code
 */
class PhpParameterRealizer extends TemplateRealizer implements ParameterRealizerInterface
{
    /**
     * @param null|string $template     The template to use in the realization
     * @param string $leftDelimiter
     * @param string $rightDelimiter
     */
    public function __construct($template = '{typeHint} {passByRef}${paramName}{defValue}',
        $leftDelimiter = '{', $rightDelimiter = '}')
    {
        parent::__construct($template, $leftDelimiter, $rightDelimiter);
    }


    /**
     * Transform a Parameter object into a valid chunk of php code for a method or function parameter definition
     * @param Parameter $parameter
     * @return mixed|void
     */
    public function realize(Parameter $parameter)
    {
        return trim($this->realizeVars($this->getTmplVars($parameter)));
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
    private function getTmplVars(Parameter $parameter)
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
