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
use Phpy\Realizer\ValueRealizerInterface;
use Phpy\Realizer\PhpValueRealizer;

/**
 * Class Description
 *
 * @package    Phpy
 * @author     Nicolò Martini <nicmartnic@gmail.com>
 */
class PhpPropertyRealizer extends TemplateRealizer implements PropertyRealizerInterface
{
    /** @var ValueRealizerInterface */
    private $valueRealizer;

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
     * Set ValueRealizer
     *
     * @param \Phpy\Realizer\ValueRealizerInterface $valueRealizer
     *
     * @return PhpPropertyRealizer The current instance
     */
    public function setValueRealizer(\Phpy\Realizer\ValueRealizerInterface $valueRealizer)
    {
        $this->valueRealizer = $valueRealizer;
        return $this;
    }

    /**
     * Get ValueRealizer
     *
     * @return \Phpy\Realizer\ValueRealizerInterface
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