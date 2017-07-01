<?php

namespace Eightfold\Documenter\Traits;

use Eightfold\Documenter\Php\Property;

trait Symbolic
{
    /**
     * Storage for symbolsOrdered()
     *
     * @var array
     *
     * @category Get and store symbols
     */
    private $symbolsOrdered = [];

    /**
     * Storage for properties()
     *
     * @var array
     *
     * @category Get and store symbols
     */
    // private $properties = [];

    /**
     * Storage for propoertiesOrdered()
     *
     * @var array
     *
     * @category Get and store symbols
     */
    protected $propertiesOrdered = [];

    /**
     * Storage for methods()
     *
     * @var array
     *
     * @category Get and store symbols
     */
    // private $methods = [];

    /**
     * Storage for methodsOrdered()
     *
     * @var array
     *
     * @category Get and store symbols
     */
    protected $methodsOrdered = [];

    /**
     * The properties and methods owned by this class ordered.
     *
     * @return [type] [description]
     *
     * @category Get and store symbols
     */
    public function symbolsOrdered()
    {
        return array_merge_recursive($this->propertiesOrdered(), $this->methodsOrdered());
    }

    /**
     * Get Property with name
     *
     * @param  string $name The name of the Property to retrieve.
     * @return Eightfold\Documenter\Models\ObjectProperty The property with the
     *                                                           given name.
     *
     * @category Get and store symbols
     */
    public function propertyWithSlug($name)
    {
        $return = null;
        foreach ($this->properties() as $property) {
            if ($property->name() == '$'. $name) {
                $return = $property;
                break;
            }
        }
        return $return;
    }

    /**
     * All the properties owned by this class ordered.
     *
     * @return [type] [description]
     *
     * @category Get and store symbols
     */
    private function propertiesOrdered()
    {
        return $this->getOrdered('propertiesOrdered', $this->properties(), 'properties');
    }

    /**
     * All the properties owned by this class.
     *
     * @return [type] [description]
     *
     * @category Get and store symbols
     */
    private function properties()
    {
        if (count($this->properties) == 0 && count($this->reflector->getProperties()) > 0) {
            $return = [];
            foreach($this->reflector->getProperties() as $property) {
                $return[] = new Property($this, $property);
            }
            $this->properties = $return;
        }
        return $this->properties;
    }

    /**
     * Get Method with name
     *
     * @param  string $name The name of the method to retrieve.
     * @return Eightfold\Documenter\Models\ObjectMethod The method with the
     *                                                         given name.
     *
     * @category Get and store symbols
     */
    public function methodWithName($name)
    {
        $return = null;
        foreach ($this->methods() as $method) {
            if ($method->name() == $name) {
                $return = $method;
                break;
            }
        }
        return $return;
    }

    public function methodWithSlug($slug)
    {
        $methodName = ($slug == '__construct')
            ? $slug
            : camel_case($slug);
        return $this->methodWithName($methodName);
    }

    /**
     * The methods declared by the Class in a specified order
     *
     * Methods are grouped by @category, then by access level, then alphabetical
     * by name ascending.
     *
     * @return array A multi-dimensional associative array
     *               `array['category']['access']`
     *
     * @category Get and store symbols
     */
    private function methodsOrdered()
    {
        return $this->getOrdered('methodsOrdered', $this->methods());
    }

    /**
     * All the methods declared by this scope.
     *
     * @return array An indexed array of ObjectMethods.
     *
     * @category Get and store symbols
     */
    // private function methods()
    // {
    //     if (count($this->methods) == 0 && count($this->raw->methods) > 0) {
    //         $return = [];
    //         foreach($this->raw->methods as $method) {
    //             $return[] = new ObjectMethod($this, $method);
    //         }
    //         $this->methods = $return;
    //     }
    //     return $this->methods;
    // }

    /******************/
    /* Ordered things */
    /******************/
    /**
     * Allows for the processing of multiple types of symbols
     *
     * For example, methods inherited by this Class can be created by passing in an
     * array of methods, and changing the propertyName to something more appropriate.
     *
     * @param  string $propertyName The desired name to store in this instance.
     * @param  array  $methods      An array of ObjectMethods to sort.
     * @return array A multi-dimensional associative array
     *               `array['category']['access']`
     *
     * @category Helpers
     */
    protected function getOrdered($propertyName, $symbols, $symbolType = 'methods')
    {
        if (count($this->{$propertyName}) == 0) {
            $staticPublic = 0;
            $staticProtected = 0;
            $staticPrivate = 0;
            $public = 0;
            $protected = 0;
            $private = 0;
            $build = [];
            foreach ($symbols as $symbol) {
                $category = (strlen($symbol->category()) > 0)
                    ? $symbol->category()
                    : 'NO_CATEGORY';
                $accessAndType = '';
                if ($this->symbolIsStatic($symbol) && $this->symbolIsPublic($symbol)) {
                    $accessAndType = 'static_public';
                    $staticPublic++;

                } elseif ($this->symbolIsStatic($symbol) && $this->symbolIsProtected($symbol)) {
                    $accessAndType = 'static_protected';
                    $staticProtected++;

                } elseif ($this->symbolIsStatic($symbol) && $this->symbolIsPrivate($symbol)) {
                    $accessAndType = 'static_private';
                    $staticPrivate++;

                } elseif ($this->symbolIsProtected($symbol)) {
                    $accessAndType = 'protected';
                    $protected++;

                } elseif ($this->symbolIsPrivate($symbol)) {
                    $accessAndType = 'private';
                    $private++;

                } else {
                    $accessAndType = 'public';
                    $public++;

                }
                $build[$category][$accessAndType][$symbolType][$symbol->name()] = $symbol;
            }

            if ($public == 0 && $protected == 0 && $private == 0 && $staticPublic == 0 && $staticProtected == 0 && $staticPrivate == 0) {
                $this->{$propertyName} = [];

            } else {
                foreach ($build as $category => $accessLevels) {
                    foreach ($accessLevels as $access => $symbolTypes) {
                        foreach ($symbolTypes as $symbolType => $symbols);
                        ksort($symbols);
                        $build[$category][$access][$symbolType] = $symbols;

                    }
                }
                $this->{$propertyName} = $build;

            }
        }
        return $this->{$propertyName};
    }

    private function symbolIsStatic($symbol)
    {
        return $this->symbolIs($symbol, 'isStatic');
    }

    private function symbolIsPublic($symbol)
    {
        return $this->symbolIs($symbol, 'isPublic');
    }

    private function symbolIsProtected($symbol)
    {
        return $this->symbolIs($symbol, 'isProtected');
    }

    private function symbolIsPrivate($symbol)
    {
        return $this->symbolIs($symbol, 'isPrivate');
    }

    private function symbolIs($symbol, $functionName)
    {
        return (method_exists($symbol, $functionName) && $symbol->{$functionName}());
    }
}
