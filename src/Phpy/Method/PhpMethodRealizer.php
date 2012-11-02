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

use Phpy\Realizer\TemplateRealizer;
use Phpy\Func\FuncRealizerInterface;

/**
 * Realize a Method objecy into valid php-code
 *
 * @package    Phpy
 * @author     Nicolò Martini <nicmartnic@gmail.com>
 */
class PhpMethodRealizer extends TemplateRealizer implements MethodRealizerInterface
{
    /**
     * @var FuncRealizerInterface
     */
    private $funcRealizer;

    /**
     * @param \Phpy\Func\FuncRealizerInterface $funcRealizer
     * @param string $template
     */
    public function __construct(FuncRealizerInterface $funcRealizer, $template = "{modifiers} {function}")
    {
        parent::__construct($template);

        $this->funcRealizer = $funcRealizer;
    }

    /**
     * Realize the method into valid php-code
     *
     * @param Method $method
     * @return string
     */
    public function realize(Method $method)
    {
        return $this->realizeVars($this->getTmplVars($method));
    }

    /**
     * Returns the variable to inject in the template
     *
     * @param Method $method
     * @return array
     */
    private function getTmplVars(Method $method)
    {
        return array(
            'modifiers' => $this->getModifiersString($method),
            'function' => $this->funcRealizer->realize($method)
        );
    }

    /**
     * Returns the modifier method prefix
     *
     * @param Method $method
     *
     * @return string
     */
    private function getModifiersString(Method $method)
    {
        $modifiers = array();

        if ($method->isAbstract())
            $modifiers[] = 'abstract';
        if ($method->isFinal())
            $modifiers[] = 'final';

        $modifiers[] = $method->getVisibility();

        if ($method->isStatic())
            $modifiers[] = 'static';

        return implode(' ', $modifiers);
    }
}