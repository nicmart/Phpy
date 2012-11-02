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

    /**
     * Determines if the body should be included in the realization
     *
     * @var bool
     */
    private $includeBody = true;

    private $defaultTemplate = 'function({parametersList}){realizedBody}';

    private $bodyTemplate = <<<TEMPLATE

{
    {body}
}
TEMPLATE;



    /**
     * @param ParameterRealizerInterface $parameterRealizer
     * @param null|string $template
     * @param null $bodyTemplate
     */
    public function __construct(ParameterRealizerInterface $parameterRealizer, $template = null, $bodyTemplate = null)
    {
        $this->parameterRealizer = $parameterRealizer;

        if (!isset($template))
            $template = $this->defaultTemplate;

        if (isset($bodyTemplate))
            $this->bodyTemplate = $bodyTemplate;

        parent::__construct($template);
    }

    /**
     * @param Func $function
     * @param bool $includeBody
     * @return string
     */
    public function realize(Func $function, $includeBody = true)
    {
        return $this->realizeVars($this->getTmplVars($function, $includeBody));
    }

    /**
     * @param Func $function
     * @param bool $includeBody
     *
     * @return array
     */
    private function getTmplVars(Func $function, $includeBody)
    {
        $realizedParams = array();

        foreach ($function->getParameters() as $param) {
            $realizedParams[] = $this->parameterRealizer->realize($param);
        }

        return array(
            'parametersList' => implode(', ', $realizedParams),
            'realizedBody' => $includeBody ? $this->getRealizedBody($function) : '',
        );
    }

    /**
     * Returns the function body enclosed by brackets
     * @param Func $function
     * @return string
     */
    private function getRealizedBody(Func $function)
    {
        return $this->realizeVars(array('body' => $function->getBody()), $this->bodyTemplate);
    }
}
