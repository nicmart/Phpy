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

use Phpy\Func\Func;

/**
 * Phpy method abstraction
 *
 * @package    Phpy
 * @author     Nicolò Martini <nicmartnic@gmail.com>
 */
class Method extends Func
{
    /**
     * The available visibilites for methods
     * @var array
     */
    private static $visibilities = array('private', 'protected', 'public');

    /**
     * @var string
     */
    private $visibility;

    /**
     * @var bool
     */
    private $static = false;

    /**
     * @var bool
     */
    private $abstract = false;

    /**
     * @var bool
     */
    private $final = false;

    /**
     * @param string $name          The name of the method
     * @param array $params         An array of \Phpy\Parameter\Parameter objects
     * @param string $visibility    The visibility of the method
     * @param bool $isAbstract      Is the method abstract?
     * @param bool $isStatic        Is the method static?
     * @param bool $isFinal         Is the method final?
     */
    public function __construct($name, $params = array(), $visibility = 'public', $isAbstract = false, $isStatic = false, $isFinal = false)
    {
        parent::__construct($name, $params);

        $this
            ->setVisibility($visibility)
            ->setAbstract($isAbstract)
            ->setStatic($isStatic)
            ->setFinal($isFinal)
        ;
    }

    /**
     * Set Abstract
     *
     * @param boolean $abstract
     * @throws \BadMethodCallException
     *
     * @return Method The current instance
     */
    public function setAbstract($abstract)
    {
        if ($abstract && $this->isFinal())
            throw new \BadMethodCallException('Cannot set a final method as abstract');

        $this->abstract = $abstract;
        return $this;
    }

    /**
     * Is Abstract
     *
     * @return boolean
     */
    public function isAbstract()
    {
        return $this->abstract;
    }

    /**
     * Set Final
     *
     * @param boolean $final
     * @throws \BadMethodCallException
     *
     * @return Method The current instance
     */
    public function setFinal($final)
    {
        if ($final && $this->isAbstract())
            throw new \BadMethodCallException('Cannot set an abstract method as final');

        $this->final = $final;
        return $this;
    }

    /**
     * Is Final
     *
     * @return boolean
     */
    public function isFinal()
    {
        return $this->final;
    }

    /**
     * Set Static
     *
     * @param boolean $static
     *
     * @return Method The current instance
     */
    public function setStatic($static)
    {
        $this->static = $static;
        return $this;
    }

    /**
     * Is Static
     *
     * @return boolean
     */
    public function isStatic()
    {
        return $this->static;
    }

    /**
     * Set Visibility
     *
     * @param string $visibility
     *
     * @throws \OutOfBoundsException
     * @return Method The current instance
     */
    public function setVisibility($visibility)
    {
        if (!in_array($visibility, static::$visibilities)) {
            $visList = implode(', ', static::$visibilities);
            throw new \OutOfBoundsException(
              "Provided visibility ($visibility) is not in the list of allowed ones ($visList)"
            );
        }

        $this->visibility = $visibility;
        return $this;
    }

    /**
     * Get Visibility
     *
     * @return string
     */
    public function getVisibility()
    {
        return $this->visibility;
    }
}