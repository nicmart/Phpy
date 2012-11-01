<?php
namespace Phpy\Func;

use Phpy\Parameter\ParameterRealizerInterface;
use Phpy\Realizer\TemplateRealizer;

/**
 * Transform a Func object into a valid php function definition
 * Needs a @link ParameterRealizerInterface
 */
class PhpFuncRealizer extends TemplateRealizer implements FuncRealizerInterface
{
    /**
     * @var ParameterRealizerInterface
     */
    private $parameterRealizer;

    private $defaultTemplate = <<<TEMPLATE
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

        if (!isset($template))
            $template = $this->defaultTemplate;

        parent::__construct($template);
    }

    /**
     * @param Func $function
     * @return string
     */
    public function realize(Func $function)
    {
        return $this->realizeVars($this->getTmplVars($function));
    }

    /**
     * @param Func $function
     * @return array
     */
    private function getTmplVars(Func $function)
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
