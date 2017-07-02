<?php

namespace Eightfold\Documenter\Php;

use phpDocumentor\Reflection\TraitReflector;

use Eightfold\Documenter\Php\Project;

use Eightfold\Documenter\Interfaces\HasDeclarations;

use Eightfold\Documenter\Traits\DocBlockable;
use Eightfold\Documenter\Traits\Nameable;
use Eightfold\Documenter\Traits\Symbolic;

/**
 * Represents a `trait` within a project.
 *
 * @category Project object
 */
class Trait_ extends TraitReflector implements HasDeclarations
{
    use DocBlockable,
        Nameable,
        Symbolic;

    public $project = null;

    private $reflector = null;

    private $url = '';

    public function __construct(Project $project, TraitReflector $reflector)
    {
        $this->project = $project;
        $this->reflector = $reflector;
        $this->node = $this->reflector->getNode();
        $this->context = $this->reflector->context;
    }

    public function methods()
    {
        $objects = $this->reflector->getMethods();
        // dd($objects);
        if (count($objects) == 0) {
            return [];
        }

        if (count($this->methods) == 0) {
            $return = [];
            foreach ($objects as $object) {
                $return[] = new Method($this, $object);
            }
            $this->methods = $return;
        }
        return $this->methods;
    }

    // public function methods()
    // {
    //     return array_values($this->reflector->methods);
    // }

    public function namespaceName()
    {
        $parts = explode('\\', $this->longName());
        array_pop($parts);
        return implode('\\', $parts);
    }

    public function url()
    {
        if (strlen($this->url) == 0) {
            $slugged = [];
            foreach ($this->node->namespacedName->parts as $part) {
                $slugged[] = kebab_case($part);
            }
            array_shift($slugged);
            array_shift($slugged);
            $thisPath = implode('/', $slugged);
            $this->url = $this->project->url() .'/'. $thisPath;
        }
        return $this->url;
    }

    public function largeDeclaration($highlight = true, $withLink = true)
    {
        return $this->buildDeclaration([
            'objectType' => 'trait',
            'highlight' => $highlight,
            'withLink' => $withLink,
            'showTraitKeyword' => true
        ]);
    }

    public function mediumDeclaration($highlight = true, $withLink = true)
    {
        return $this->buildDeclaration([
            'objectType' => 'trait',
            'highlight' => $highlight,
            'withLink' => $withLink,
            'showTraitKeyword' => true
        ]);
    }

    public function smallDeclaration($highlight = true, $withLink = true)
    {
        return $this->buildDeclaration([
            'objectType' => 'trait',
            'highlight' => $highlight,
            'withLink' => $withLink,
            'showTraitKeyword' => true,
            'showTraitKeyword' => true
        ]);
    }

    public function miniDeclaration($highlight = true, $withLink = true)
    {
        return $this->buildDeclaration([
            'objectType' => 'trait',
            'highlight' => $highlight,
            'withLink' => $withLink,
            'showTraitKeyword' => true
        ]);
    }

    public function microDeclaration($highlight = true, $withLink = true, $showKeywords = true)
    {
        return $this->buildDeclaration([
            'objectType' => 'trait',
            'highlight' => $highlight,
            'withLink' => $withLink,
            'showTraitKeyword' => false
        ]);
    }
}
