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
    private $template;
    private $autoIndent = true;

    /**
     * @param string $template          The tempalte to be rendered
     * @param string $leftDelimiter     The left delimiter for the template vars
     * @param string $rightDelimiter    The right delimiter for the template vars
     */
    public function __construct($template, $leftDelimiter = '{', $rightDelimiter = '}')
    {
        $this->template = $template;
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
     *
     * @return string
     */
    public function realizeVars(array $vars)
    {
        $realizedString = $this->template;
        foreach ($vars as $key => $value) {
            $pattern = "/(^[\\s\\t]*?)?{$this->leftDelimiter}$key{$this->rightDelimiter}/m";
            $replace = '$1' . $this->addStringToBeginningOfLines($value, '$1');

            $realizedString = preg_replace($pattern, $replace, $realizedString);
        }

        return $realizedString;
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