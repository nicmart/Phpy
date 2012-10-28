<?php
namespace Phpy\Parameter;
/**
 * A function or method parameter representation
 */
class Parameter
{
    /** @var string */
    private $name;

    /** @var string */
    private $typeHint;

    /** @var bool */
    private $byRef = false;

    /** @var bool */
    private $hasDefaultValue = false;

    /** @var mixed */
    private $defaultValue;

    /**
     * @param string $name
     * @param null $typeHint
     */
    public function __construct($name, $typeHint = null)
    {
        $this->name = $name;
        $this->typeHint = $typeHint;
    }

    /**
     * Set ByRef
     *
     * @param bool $byRef
     *
     * @return Parameter The current instance
     */
    public function setByRef($byRef)
    {
        $this->byRef = $byRef;
        return $this;
    }

    /**
     * Get ByRef
     *
     * @return boolean
     */
    public function isByRef()
    {
        return $this->byRef;
    }

    /**
     * Set DefaultValue
     *
     * @param mixed $defaultValue
     *
     * @throws \InvalidArgumentException
     * @return Parameter The current instance
     */
    public function setDefaultValue($defaultValue)
    {
        if (!is_scalar($defaultValue) && !is_array($defaultValue)) {
            throw new \InvalidArgumentException('Default PHP Values can be only scalars or arrays');
        }

        $this->defaultValue = $defaultValue;
        $this->hasDefaultValue = true;

        return $this;
    }

    /**
     * @return Parameter The current instance
     */
    public function removeDefaultValue()
    {
        $this->hasDefaultValue = false;
        unset($this->defaultValue);

        return $this;
    }

    /**
     * Get DefaultValue
     *
     * @throws BadMethodCallException
     * @return mixed
     */
    public function getDefaultValue()
    {
        if (!$this->hasDefaultValue)
            throw new \BadMethodCallException('The Parameter has no default value');

        return $this->defaultValue;
    }

    /**
     * Get HasDefaultValue
     *
     * @return boolean
     */
    public function hasDefaultValue()
    {
        return $this->hasDefaultValue;
    }

    /**
     * Set Name
     *
     * @param string $name
     *
     * @return Parameter The current instance
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get Name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set TypeHint
     *
     * @param string $typeHint
     *
     * @return Parameter The current instance
     */
    public function setTypeHint($typeHint)
    {
        $this->typeHint = $typeHint;
        return $this;
    }

    /**
     * Get TypeHint
     *
     * @return string
     */
    public function getTypeHint()
    {
        return $this->typeHint;
    }
}
