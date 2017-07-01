<?php

namespace Eightfold\DocumentorLaravel\Php;

use phpDocumentor\Reflection\InterfaceReflector;

use Eightfold\DocumentorLaravel\Php\Project;

use Eightfold\DocumentorLaravel\Traits\Nameable;

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
