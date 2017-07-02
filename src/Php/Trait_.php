<?php

namespace Eightfold\Documenter\Php;

use phpDocumentor\Reflection\TraitReflector;

use Eightfold\Documenter\Php\Project;

use Eightfold\Documenter\Interfaces\HasDeclarations;

use Eightfold\Documenter\Traits\DocBlockable;
use Eightfold\Documenter\Traits\Nameable;
use Eightfold\Documenter\Traits\Symbolic;
use Eightfold\Documenter\Traits\HighlightableString;

/**
 * Represents a `trait` within a project.
 *
 * @category Project object
 */
class Trait_ extends TraitReflector implements HasDeclarations
{
    use DocBlockable,
        Nameable,
        Symbolic,
        HighlightableString;

    public $project = null;

    private $reflector = null;

    private $url = '';

    public function __construct(Project $project, TraitReflector $reflector)
    {
        $this->project = $project;
        $this->reflector = $reflector;
        $this->node = $this->reflector->getNode();
    }

    public function methods()
    {
        $objects = $this->reflector->getMethods();
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

    /**
     * [processDeclaration description]
     * @param  [type]  $highlight          [description]
     * @param  [type]  $withLink           [description]
     * @param  boolean $processInheritance [description]
     * @param  boolean $processInterfaces  [description]
     * @param  boolean $processTraits      [description]
     * @return [type]                      [description]
     *
     * @category Declarations
     */
    private function processDeclaration($highlight, $withLink, $showTraitKeyword = true)
    {
        if ($withLink) {
            $build[] = '<a class="call-signature" href="'. url($this->url()) .'">';
        }

        $build[] = $this->processOpening($highlight, $showTraitKeyword);

        $build[] = ($withLink)
            ? '</a>'
            : '';

        return implode(' ', $build);
    }

    /**
     * [processOpening description]
     * @param  [type] $highlight [description]
     * @return [type]            [description]
     *
     * @category Declarations
     */
    private function processOpening($highlight, $showTraitKeyword)
    {
        $build = [];

        if ($showTraitKeyword) {
            $build[] = $this->getHighlightedString('trait');

        }

        $build[] = $this->name();

        return implode(' ', $build);
    }

    /**
     * [largeDeclaration description]
     *
     * @param  boolean $highlight [description]
     * @param  boolean $withLink  [description]
     * @return [type]             [description]
     *
     * @category Declarations
     */
    public function largeDeclaration($highlight = true, $withLink = true)
    {
        return $this->processDeclaration($highlight, $withLink);
    }

    /**
     * [mediumDeclaration description]
     *
     * @param  boolean $highlight [description]
     * @param  boolean $withLink  [description]
     * @return [type]             [description]
     *
     * @category Declarations
     */
    public function mediumDeclaration($highlight = true, $withLink = true)
    {
        return $this->processDeclaration($highlight, $withLink);
    }

    /**
     * [smallDeclaration description]
     *
     * @param  boolean $highlight [description]
     * @param  boolean $withLink  [description]
     * @return [type]             [description]
     *
     * @category Declarations
     */
    public function smallDeclaration($highlight = true, $withLink = true)
    {
        return $this->processDeclaration($highlight, $withLink);
    }

    /**
     * [miniDeclaration description]
     *
     * @param  boolean $highlight [description]
     * @param  boolean $withLink  [description]
     * @return [type]             [description]
     *
     * @category Declarations
     */
    public function miniDeclaration($highlight = true, $withLink = true)
    {
        return $this->processDeclaration($highlight, $withLink);
    }

    /**
     * [microDeclaration description]
     *
     * @param  boolean $highlight    [description]
     * @param  boolean $withLink     [description]
     * @param  boolean $showKeywords [description]
     * @return [type]                [description]
     *
     * @category Declarations
     */
    public function microDeclaration($highlight = true, $withLink = true, $showKeywords = true)
    {
        return $this->processDeclaration($highlight, $withLink);
    }
}
