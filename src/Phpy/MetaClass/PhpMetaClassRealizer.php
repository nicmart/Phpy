<?php
/*
 * This file is part of Phpy.
 *
 * (c) 2012 Nicolò Martini
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Phpy\MetaClass;

use Phpy\Realizer\TemplateRealizer;
use Phpy\Property\PropertyRealizerInterface;
use Phpy\Property\PhpPropertyRealizer;
use Phpy\Method\MethodRealizerInterface;
use Phpy\Method\PhpMethodRealizer;

/**
 * Class Description
 *
 * @package    Phpy
 * @author     Nicolò Martini <nicmartnic@gmail.com>
 */
class PhpMetaClassRealizer extends TemplateRealizer implements MetaClassRealizerInterface
{
    /**
     * @var MethodRealizerInterface
     */
    private $methodRealizer;

    /**
     * @var PropertyRealizerInterface
     */
    private $propertyRealizer;

    private $defaultTemplate = <<<TEMPLATE
class {className}{extends}{interfaces}
{
    {properties}

    {methods}
}
TEMPLATE;


    /**
     * @param null $template
     * @param \Phpy\Method\MethodRealizerInterface $methodRealizer
     * @param \Phpy\Property\PropertyRealizerInterface $propertyRealizer
     */
    public function __construct($template = null,
        MethodRealizerInterface $methodRealizer = null,
        PropertyRealizerInterface $propertyRealizer = null
    ) {
        if (!isset($template))
            $template = $this->defaultTemplate;

        if (!isset($methodRealizer))
            $methodRealizer = new PhpMethodRealizer;

        if (!isset($propertyRealizer))
            $propertyRealizer = new PhpPropertyRealizer;

        $this
            ->setMethodRealizer($methodRealizer)
            ->setPropertyRealizer($propertyRealizer)
        ;

        parent::__construct($template);
    }

    /**
     * Set MethodRealizer
     *
     * @param MethodRealizerInterface $methodRealizer
     *
     * @return PhpMetaClassRealizer The current instance
     */
    public function setMethodRealizer(MethodRealizerInterface $methodRealizer)
    {
        $this->methodRealizer = $methodRealizer;
        return $this;
    }

    /**
     * Get MethodRealizer
     *
     * @return MethodRealizerInterface
     */
    public function getMethodRealizer()
    {
        return $this->methodRealizer;
    }

    /**
     * Set PropertyRealizer
     *
     * @param PropertyRealizerInterface $propertyRealizer
     *
     * @return PhpMetaClassRealizer The current instance
     */
    public function setPropertyRealizer(PropertyRealizerInterface $propertyRealizer)
    {
        $this->propertyRealizer = $propertyRealizer;
        return $this;
    }

    /**
     * Get PropertyRealizer
     *
     * @return PropertyRealizerInterface
     */
    public function getPropertyRealizer()
    {
        return $this->propertyRealizer;
    }

    /**
     * @param MetaClass $class
     * @return mixed
     */
    public function realize(MetaClass $class)
    {
        return $this->realizeVars($this->getTmplVars($class));
    }

    /**
     * Get Vars to be rendered in the template
     *
     * @param MetaClass $class
     * @return array
     */
    private function getTmplVars(MetaClass $class)
    {
        $parent = $class->getParent();
        $interfaces = $class->getInterfaces();

        return array(
            'className' => 'ClassName',
            'extends' => $parent ? ' extends ' . $parent->getName() : '',
            'interfaces' => $interfaces ? ' implements ' . implode(', ', $interfaces) : '',
            'properties' => $this->realizeProperties($class),
            'methods' => $this->realizeMethods($class)
        );
    }

    /**
     * Realize the set of properties
     *
     * @param MetaClass $class
     * @return string
     */
    private function realizeProperties(MetaClass $class)
    {
        $realizedProps = array();

        foreach ($class->getProperties() as $prop) {
            $realizedProps[] = $this->propertyRealizer->realize($prop);
        }

        return $realizedProps ? implode(';' . PHP_EOL .PHP_EOL, $realizedProps) . ';' : '';
    }

    /**
     * Realize the set of methods
     *
     * @param MetaClass $class
     * @return string
     */
    private function realizeMethods(MetaClass $class)
    {
        $realizedMethods = array();

        foreach ($class->getMethods() as $method) {
            $realizedMethods[] = $this->methodRealizer->realize($method);
        }

        return $realizedMethods ? implode(';' . PHP_EOL .PHP_EOL, $realizedMethods) . ';' : '';
    }
}