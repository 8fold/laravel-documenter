<?php

namespace Eightfold\Documenter\Traits;

trait Pathable
{
    /**
     * Storage for the slug based on class long name
     *
     * @var string
     *
     * @category Get and store symbols
     */
    protected $fullSlug = '';

    /**
     * Return the url based on the passed parameters.
     *
     * @param  varies $projectOrClass Eightfold\Documenter\Models\Project|
     *                                Eightfold\Documenter\Models\Project The
     *                                project or class in which the element is
     *                                contained.
     * @param  string $symbolType     Can be "methods" or "properties". Used when
     *                                creating /[class-name]/methods/[method-name]
     * @return string                 The generated URL.
     */
    private function getUrl($projectOrClass, $symbolType = null)
    {
        $urlPrefix = '';
        if (method_exists($projectOrClass, 'versionUrl')) {
            $urlPrefix = $projectOrClass->versionUrl();

        } else {
            $urlPrefix = $projectOrClass->url($projectOrClass, $symbolType);

        }

        if (is_null($symbolType)) {
            return $urlPrefix . '/'. $this->fullSlug();
        }
        return $urlPrefix .'/'. $symbolType .'/'. $this->name();
    }

    /**
     * Path made from class long name.
     *
     * Converts Eightfold\Documenter\Models\ObjectMethod
     * into models/object-method
     *
     * @return string The resulting path for the Class.
     *
     * @category Resource locators
     */
    private function fullSlug()
    {
        if (strlen($this->fullSlug) == 0 && isset($this->raw)) {
            $classNiceNameParts = explode('\\', static::classMediumNameFromLongName($this->raw->longName));
            $slugified = [];
            foreach ($classNiceNameParts as $part) {
                $slugified[] = kebab_case($part);
            }
            $this->fullSlug = implode('/', $slugified);
        }
        return $this->fullSlug;
    }
}
