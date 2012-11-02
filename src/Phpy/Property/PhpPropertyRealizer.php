<?php
/*
 * This file is part of Phpy.
 *
 * (c) 2012 Nicolò Martini
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Phpy\Property;

use Phpy\Realizer\TemplateRealizer;

/**
 * Class Description
 *
 * @package    Phpy
 * @author     Nicolò Martini <nicmartnic@gmail.com>
 */
class PhpPropertyRealizer extends TemplateRealizer implements PropertyRealizerInterface
{
    /**
     * @param string $template
     */
    public function __construct($template = '{modifiers} ${propName}{defValue}')
    {
        parent::__construct($template);
    }

    /**
     * Realize a Property object in a valid php class property declaration
     * @param Property $property
     * @return string
     */
    public function realize(Property $property)
    {
        return $this->realizeVars($this->getTmplVars($property));
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
     * Template vars used to render the template
     *
     * @param Property $property
     * @return array
     */
    private function getTmplVars(Property $property)
    {
        return array(
            'modifiers' => $this->getModifiersString($property),
            'propName' => $property->getName(),
            'defValue' => $property->hasDefaultValue()
                ? ' = ' . $this->renderDefaultValue($property->getDefaultValue()) : ''
        );
    }

    /**
     * Returns the string of property modifiers
     *
     * @param Property $property
     * @return string
     */
    private function getModifiersString(Property $property)
    {
        $modifiers = array();

        $modifiers[] = $property->getVisibility();

        if ($property->isStatic())
            $modifiers[] = 'static';

        return implode(' ', $modifiers);
    }
}