<?php
namespace Phpy\Func;

use Phpy\Parameter\ParameterRealizerInterface;

/**
 * Transform a Func object into a valid php function definition
 * Needs a @link ParameterRealizerInterface
 */
class PhpFuncRealizer implements FuncRealizerInterface
{
    /**
     * @var ParameterRealizerInterface
     */
    private $parameterRealizer;

    private $template = <<<TEMPLATE
    function({parametersList})
    {
        {body}
    }
TEMPLATE;


    /**
     * @param ParameterRealizerInterface $parameterRealizer
     * @param null|string $template
     */
    public function __construct(ParameterRealizerInterface $parameterRealizer, $template = null)
    {
        $this->parameterRealizer = $parameterRealizer;

        if (isset($template))
            $this->template = $template;
    }

    /**
     * @param Func $function
     * @return string
     */
    public function realize(Func $function)
    {
        $string = $this->template;

        foreach ($this->getTmplValues($function) as $type => $value) {
            $string = str_replace('{' . $type . '}', $value, $string);
        }

        return $string;
    }

    /**
     * @param Func $function
     * @return array
     */
    private function getTmplValues(Func $function)
    {
        $realizedParams = array();

        foreach ($function->getParameters() as $param) {
            $realizedParams[] = $this->parameterRealizer->realize($param);
        }

        return array(
            'parametersList' => implode(', ', $realizedParams),
            'body' => $function->getBody(),
        );
    }
}
