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

/**
 * This class represents the Property of a PHP class
 *
 * @package    Phpy
 * @author     Nicolò Martini <nicmartnic@gmail.com>
 */
class Property
{
    private $name;
    private $visibility;
    private $hasDefaultValue = false;
    private $defaultValue;
    private $isStatic = false;

    private static $visibilites = array('private', 'protected', 'public');

    /**
     * Is $value a valid php propery default value?
     *
     * @param mixed $value
     * @return bool
     */
    public static function is_valid_default_value($value)
    {
        return is_scalar($value) || is_array($value) || is_null($value);
    }


    /**
     * @param string $name           The name of the property
     * @param string $visibility    The visibility of the property
     * @param null $defaultValue    The default value of the property
     * @param bool $isStatic        Is the property static?
     */
    public function __construct($name, $visibility = 'public', $defaultValue = null, $isStatic = false)
    {
        $this
            ->setName($name)
            ->setVisibility($visibility)
            ->setStatic($isStatic)
        ;

        if (isset($defaultValue))
            $this->setDefaultValue($defaultValue);
    }


    /**
     * @param string $defaultValue
     * @throws \InvalidArgumentException
     * @return Property
     */
    public function setDefaultValue($defaultValue)
    {
        if (!static::is_valid_default_value($defaultValue))
            throw new \InvalidArgumentException('Invalid default value');

        $this->defaultValue = $defaultValue;
        $this->hasDefaultValue = true;

        return $this;
    }

    /**
     * @return Property The current instance
     */
    public function removeDefaultValue()
    {
        $this->hasDefaultValue = false;
        $this->defaultValue = null;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    /**
     * @return bool
     */
    public function hasDefaultValue()
    {
        return $this->hasDefaultValue;
    }

    /**
     * @param bool $isStatic
     * @return Property The current instance
     */
    public function setStatic($isStatic)
    {
        $this->isStatic = $isStatic;
        return $this;
    }

    /**
     * @return bool
     */
    public function isStatic()
    {
        return $this->isStatic;
    }

    /**
     * @param string $name
     * @return Property
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $visibility
     * @throws \OutOfBoundsException
     * @return Property
     */
    public function setVisibility($visibility)
    {
        if (!in_array($visibility, static::$visibilites))
            throw new \OutOfBoundsException(sprintf(
                'Provided visibility (%s) is not in the list of allowed ones (%s)',
                $visibility,
                implode(', ', static::$visibilites)
            ));
        $this->visibility = $visibility;
        return $this;
    }

    /**
     * @return string
     */
    public function getVisibility()
    {
        return $this->visibility;
    }
}