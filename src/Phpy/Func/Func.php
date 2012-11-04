<?php
namespace Phpy\Func;

use Phpy\Parameter\Parameter;

/**
 */
class Func
{
    /** @var array */
    private $parameters = array();

    /** @var string */
    private $name;

    /** @var string */
    private $namespace;

    /** @var string */
    private $body;

    /**
     * @param string $name
     * @param array $params
     */
    public function __construct($name, $params = array())
    {
        $pieces = explode('\\', $name);
        $realName = array_pop($pieces);

        $this->setName($realName);

        if (count($pieces)) {
            $this->setNamespace(implode('\\', $pieces));
        }
    }

    /**
     * Set Namespace
     *
     * @param string $namespace
     *
     * @return Func The current instance
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;

        return $this;
    }

    /**
     * Get Namespace
     *
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Set Name
     *
     * @param string $name
     *
     * @return Func The current instance
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
     * Returns the full qualified name of the function, i.e. the name prefixed with namespaces
     * @return string
     */
    public function getFullQualifiedName()
    {
        return $this->getNamespace() . '\\' . $this->getName();
    }

    /**
     * Set Parameters
     *
     * @param array $parameters
     *
     * @return Func The current instance
     */
    public function setParameters(array $parameters = array())
    {
        $this->parameters = array();

        foreach ($parameters as $parameter) {
            $this->addParameter($parameter);
        }

        return $this;
    }

    /**
     * Get Parameters
     *
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Set Body
     *
     * @param string $body
     *
     * @return Func The current instance
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get Body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param \Phpy\Parameter\Parameter $parameter
     *
     * @return Func The current instance
     */
    public function addParameter(Parameter $parameter)
    {
        $this->parameters[] = $parameter;

        return $this;
    }


}
