<?php

namespace Eightfold\Documenter\Php;

/**
 * Represents a `class` outside the current project.
 *
 * Sometimes projects will extend classes found in other projects. In those cases,
 * Documenter instantiates this class instead of `Class_`. Therefore, `ClassExternal`
 * has the minimum functionality necessary to display information related to the
 * external class without essentially making it part of the project being explored.
 *
 * @category Project object
 */
class ClassExternal
{
    /**
     * [$testing description]
     * @var string
     */
    static public $testing = 'string';

    /**
     * Copy of `$namespaceParts` for caching.
     *
     * @var array
     */
    private $parts = [];

    /**
     * @category Initializer
     *
     * @param array $namespaceParts Array containing the full class name of the
     *                              external class in order.
     */
    public function __construct($namespaceParts)
    {
        $this->parts = $namespaceParts;
    }

    /**
     * Imploded `$parts` using a backslash for the separater after removing last
     * element from the array.
     *
     * @return string
     */
    public function space()
    {
        $copy = $this->parts;
        array_pop($copy);
        return implode('\\', $copy);
    }

    /**
     * Last element in `$parts`.
     *
     * @return string
     */
    public function name()
    {
        return array_pop($this->parts);
    }

    /**
     * Always returns false as this class is specifically for external classes.
     *
     * @return boolean Always false.
     */
    public function isInProjectSpace()
    {
        return false;
    }
}
