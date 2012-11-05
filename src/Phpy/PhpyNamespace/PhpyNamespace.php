<?php
/*
 * This file is part of Phpy.
 *
 * (c) 2012 Nicolò Martini
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Phpy\PhpyNamespace;

/**
 * Class Description
 *
 * @package    Phpy
 * @author     Nicolò Martini <nicmartnic@gmail.com>
 */
class PhpyNamespace
{
    const NS_SEPARATOR = '\\';
    const NS_GLOBAL = '\\';

    private $namespacePieces = array();

    /**
     * @param string $namespace The namespace identifier
     */
    public function __construct($namespace = self::NS_GLOBAL)
    {
        $this->setNamespace($namespace);
    }

    /**
     * Set the namespace by its identifier.
     * $namespace is assumed to be a fully qualified namespace, even if there is no trailing backslash
     *
     * @param string $namespace The namespace identifier.
     * @return PhpyNamespace    The current instance
     */
    public function setNamespace($namespace)
    {
        $this->namespacePieces = explode(static::NS_SEPARATOR, $namespace);

        if (substr($namespace, 0, 1) === static::NS_SEPARATOR) {
            array_shift($this->namespacePieces);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getExplodedNamespace()
    {
        return $this->namespacePieces;
    }

    /**
     * @param array $nsPieces
     * @return PhpyNamespace    The current instance
     */
    public function setExplodedNamespace(array $nsPieces)
    {
        $this->namespacePieces = $nsPieces;

        return $this;
    }

    /**
     * Returns the fully qualified name of the namespace
     *
     * @return string   The fully qualified name of the namespace
     */
    public function getNamespace()
    {
        return static::NS_SEPARATOR . implode(static::NS_SEPARATOR, $this->namespacePieces);
    }

    /**
     * Return the common ancestor of the current namespace and $namespace
     *
     * @param PhpyNamespace $namespace      The namespace to compare with
     * @return PhpyNamespace                The ancestor namespace
     */
    public function getCommonAncestor(PhpyNamespace $namespace)
    {
        $pieces1 = $this->getExplodedNamespace();
        $pieces2 = $namespace->getExplodedNamespace();
        $piecesNew = array();

        foreach($pieces1 as $index => $piece1) {
            if (isset($pieces2[$index]) && $pieces2[$index] === $piece1) {
                $piecesNew[] = $piece1;
            } else {
                break;
            }
        }

        $ancestorNs = new PhpyNamespace();
        $ancestorNs->setExplodedNamespace($piecesNew);

        return $ancestorNs;
    }
}