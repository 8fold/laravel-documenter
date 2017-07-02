<?php

namespace Eightfold\Documenter\Php;

use phpDocumentor\Reflection\InterfaceReflector;

use Eightfold\Documenter\Php\Project;

use Eightfold\Documenter\Traits\Nameable;

/**
 * Represents an `interface` in a project.
 *
 * @category Project object
 */
class Interface_ extends InterfaceReflector
{
    use Nameable;

    private $reflector = null;

    private $project = null;

    public function __construct(Project $project, InterfaceReflector $reflector)
    {
        $this->project = $project;
        $this->reflector = $reflector;
        $this->node = $this->reflector->getNode();
        $this->context = $this->reflector->context;
    }

    public function methods()
    {
        return array_values($this->reflector->methods);
    }

    public function namespaceName()
    {
        $parts = explode('\\', $this->longName());
        array_pop($parts);
        return implode('\\', $parts);
    }
}
