<?php
/*
 * This file is part of Phpy.
 *
 * (c) 2012 Nicolò Martini
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Phpy\Realizer;

/**
 * A base class for all realizers in the library.
 * Use a template-based string realization.
 *
 * @package    Phpy
 * @author     Nicolò Martini <nicmartnic@gmail.com>
 */
class TemplateRealizer
{
    private $leftDelimiter;
    private $rightDelimiter;
    private $defaultTemplate;
    private $autoIndent = true;

    /**
     * @param string $template          The tempalte to be rendered
     * @param string $leftDelimiter     The left delimiter for the template vars
     * @param string $rightDelimiter    The right delimiter for the template vars
     */
    public function __construct($template, $leftDelimiter = '{', $rightDelimiter = '}')
    {
        $this->defaultTemplate = $template;
        $this->leftDelimiter = $leftDelimiter;
        $this->rightDelimiter = $rightDelimiter;
    }

    /**
     * @param bool $autoIndent
     * @return TemplateRealizer The current instance
     */
    public function setAutoIndent($autoIndent)
    {
        $this->autoIndent = $autoIndent;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAutoIndent()
    {
        return $this->autoIndent;
    }

    /**
     * Perform template realization
     *
     * @param array $vars
     * @param null $template The template to realize. Null to use the default one
     *
     * @return string
     */
    public function realizeVars(array $vars, $template = null)
    {
        if (!isset($template))
            $template = $this->defaultTemplate;

        $realizedString = $template;
        foreach ($vars as $key => $value) {
            $pattern = "/(^[ \\t]*)?{$this->leftDelimiter}$key{$this->rightDelimiter}/m";
            $linePrefix = $this->isAutoIndent() ? '$1' : '';
            $replace = '$1' . $this->addStringToBeginningOfLines($value, $linePrefix);

            $realizedString = preg_replace($pattern, $replace, $realizedString);
        }

        return $realizedString;
    }

    /**
     * @param string $defaultTemplate
     * @return TemplateRealizer The current instance
     */
    public function setDefaultTemplate($defaultTemplate)
    {
        $this->defaultTemplate = $defaultTemplate;
        return $this;
    }

    /**
     * @return string
     */
    public function getDefaultTemplate()
    {
        return $this->defaultTemplate;
    }

    /**
     * Add $startString at the beginning of lines
     *
     * @param $original
     * @param $startString
     *
     * @return string
     */
    private function addStringToBeginningOfLines($original, $startString)
    {
        return implode(PHP_EOL . $startString, explode(PHP_EOL, $original));
    }
}