<?php
namespace Phpy\Parameter;

use Phpy\Realizer\TemplateRealizer;
use Phpy\Realizer\ValueRealizerInterface;
use Phpy\Realizer\PhpValueRealizer;

/**
 * Render a parameter to a php valid piece of code
 */
class PhpParameterRealizer extends TemplateRealizer implements ParameterRealizerInterface
{
    /** @var  ValueRealizerInterface */
    private $valueRealizer;

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
     * Set ValueRealizer
     *
     * @param ValueRealizerInterface $valueRealizer
     *
     * @return PhpParameterRealizer The current instance
     */
    public function setValueRealizer(ValueRealizerInterface $valueRealizer)
    {
        $this->valueRealizer = $valueRealizer;
        return $this;
    }

    /**
     * Get ValueRealizer. If no one is set, create a PhpValueRealizer by default
     *
     * @return ValueRealizerInterface
     */
    public function getValueRealizer()
    {
        if (!isset($this->valueRealizer))
            $this->setValueRealizer(new PhpValueRealizer);

        return $this->valueRealizer;
    }

    /**
     * Render the value as a default value of a php function parameter
     * @param $value
     * @throws \InvalidArgumentException
     * @return mixed|string
     */
    private function renderDefaultValue($value)
    {
        try {
            $realized = $this->getValueRealizer()->realizeValue($value);
        } catch (\InvalidArgumentException $e) {
            throw new \InvalidArgumentException('A default value can be only a scalar or an array of valid default values');
        }

        return $realized;
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
