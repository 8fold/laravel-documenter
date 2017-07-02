<?php

namespace Eightfold\Documenter\Php;

use phpDocumentor\Reflection\ClassReflector;

use Eightfold\Documenter\Php\Project;
use Eightfold\Documenter\Php\Property;
use Eightfold\Documenter\Php\Method;
use Eightfold\Documenter\Php\DocBlock;

use Eightfold\Documenter\Interfaces\HasDeclarations;

use Eightfold\Documenter\Traits\HasInheritance;
use Eightfold\Documenter\Traits\Nameable;
use Eightfold\Documenter\Traits\DocBlockable;
use Eightfold\Documenter\Traits\Symbolic;
use Eightfold\Documenter\Traits\CanBeAbstract;
use Eightfold\Documenter\Traits\CanBeFinal;
use Eightfold\Documenter\Traits\CanHaveTraits;

/**
 * Represents a `class` in a project.
 *
 * @category Project object
 */
class Class_ extends ClassReflector implements HasDeclarations
{
    use HasInheritance,
        Nameable,
        Symbolic,
        DocBlockable,
        CanBeAbstract,
        CanBeFinal,
        CanHaveTraits;

    public $project = null;

    private $reflector = null;

    protected $node = null;

    private $docBlock = null;

    private $url = '';

    private $interfaces = [];

    public function __construct(Project $project, ClassReflector $reflector)
    {
        $this->project = $project;
        $this->reflector = $reflector;
        $this->node = $this->reflector->getNode();
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

    public function namespaceName()
    {
        $parts = explode('\\', $this->longName());
        array_pop($parts);
        return implode('\\', $parts);
    }

    public function isInProjectSpace()
    {
        return $this->project->hasLongName($this->namespaceName());
    }



    /**
     * [interfaces description]
     * @return [type] [description]
     *
     * @category Modifiers
     */
    public function interfaces()
    {
        $reflectorInterfaces = $this->reflector->getInterfaces();
        if (count($reflectorInterfaces) == 0) {
            return [];
        }

        if (count($this->interfaces) == 0) {
            $return = [];
            foreach ($reflectorInterfaces as $interfaceLongName) {
                $return[] = $this->project->objectWithLongName($interfaceLongName);
            }
            $this->interfaces = $return;
        }
        return $this->interfaces;
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
    private function processDeclaration($highlight, $withLink, $processInheritance = true, $processInterfaces = true, $processTraits = true)
    {
        if ($withLink) {
            $build[] = '<a class="call-signature" href="'. url($this->url()) .'">';
        }

        $build[] = $this->processOpening($highlight);

        if ($processInheritance && !is_null($this->parent())) {
            $build[] = $this->processInheritance($highlight);

        }

        if ($processInterfaces && count($this->interfaces()) > 0) {
            $build[] = $this->processInterfaces($highlight);

        }

        if ($processTraits && count($this->traits()) > 0) {
            $build[] = $this->processTraits($highlight);

        }

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
    private function processOpening($highlight)
    {
        $build = [];

        $this->getFinalKeyword($highlight, $build);
        $this->getAbstractKeyword($highlight, $build);

        $build[] = $this->getHighlightedString('class');

        $build[] = $this->name();

        return implode(' ', $build);
    }

    /**
     * [processTraits description]
     * @param  [type] $highlight [description]
     * @return [type]            [description]
     *
     * @category Declarations
     */
    private function processTraits($highlight)
    {
        if (count($this->traits()) == 0) {
            return;
        }

        $build = [];
        if (count($this->traits()) > 0) {
            $keyword = 'trait';
            if (count($this->traits()) > 1) {
                $keyword = str_plural($keyword);
            }

            $traitsArray = [];
            foreach ($this->traits() as $trait) {
                if (!is_null($trait)) {
                    $traitsArray[] = ($highlight)
                        ? $this->getHighlightedString($trait->name(), 'related')
                        : $trait->name();
                }
            }

            $build[] = ($highlight)
                ? $this->getHighlightedString('has '. $keyword, 'traits-label')
                : 'has '. $keyword;
            $build[] = implode(', ', $traitsArray);
        }
        return implode(' ', $build);
    }


    /**
     * [processInterfaces description]
     * @param  [type] $highlight [description]
     * @return [type]            [description]
     *
     * @category Declarations
     */
    private function processInterfaces($highlight)
    {
        if (count($this->interfaces()) == 0) {
            return;
        }

        $store = [];
        foreach ($this->interfaces() as $interface) {
            $store[] = ($highlight)
                ? $this->getHighlightedString($interface->name(), 'related')
                : $interface->name();
        }

        $build = [];
        $build[] = ($highlight)
            ? $this->getHighlightedString('implements', 'implements-label')
            : 'implements';

        $build[] = implode(', ', $store);
        return implode(' ', $build);
    }

    /**
     * [processInheritance description]
     * @param  [type] $highlight [description]
     * @return [type]            [description]
     *
     * @category Declarations
     */
    private function processInheritance($highlight)
    {
        if (is_null($this->parent())) {
            return;
        }

        $build[] = ($highlight)
            ? $this->getHighlightedString('extends')
            : 'extends';

        if (is_a($this->parent(), Class_::class)) {
            $build[] = ($highlight)
                ? $this->getHighlightedString($this->parent()->name(), 'related')
                : $this->parent()->name();

        } else {
            $build[] = ($highlight)
                ? '['. $this->getHighlightedString($this->parent()->name(), 'related') .']'
                : '['. $this->parent()->name() .']';

        }


        return implode(' ', $build);
    }

    /**
     * [getHighlightedString description]
     * @param  [type] $label     [description]
     * @param  [type] $elemClass [description]
     * @return [type]            [description]
     *
     * @category Declarations
     */
    private function getHighlightedString($label, $elemClass = null)
    {
        return (is_null($elemClass))
            ? '<span class="'. $label .'">'. $label .'</span>'
            : '<span class="'. $elemClass .'">'. $label .'</span>';
    }

    /**
     * [largeDeclaration description]
     *
     * @param  boolean $highlight [description]
     * @param  boolean $withLink  [description]
     *
     * @return [type]             [description]
     *
     * @category Declarations
     */
    public function largeDeclaration($highlight = true, $withLink = true)
    {
        // final abstract class [class name]
        // extends [parent class]
        // implements [interface]
        // has traits [traits]
        return $this->processDeclaration($highlight, $withLink);
    }

    /**
     * Method name, parameters, type hints, defaults, function keyword, return type, and access level.
     *
     * @param  boolean $highlight Default is true. Whether to display the highlights.
     * @param  boolean $withLink  Default is true. Whether to create an anchor tag.
     *
     * @return [type] [description]
     *
     * @category Declarations
     */
    public function mediumDeclaration($highlight = true, $withLink = true)
    {
        // final abstract class [class name]
        // extends [parent class]
        // implements [interface]
        return $this->processDeclaration($highlight, $withLink, true, true, false);
    }

    /**
     * Method name, parameters, type hints, defaults, and function keyword.
     *
     * @return [type] [description]
     *
     * @category Declarations
     */
    public function smallDeclaration($highlight = true, $withLink = true)
    {
        // final abstract class [class name]
        // extends [parent class]
        return $this->processDeclaration($highlight, $withLink, true, false, false);
    }

    /**
     * Method name, parameters.
     *
     * @return [type] [description]
     *
     * @category Declarations
     */
    public function miniDeclaration($highlight = true, $withLink = true)
    {
        return $this->processDeclaration($highlight, $withLink, false, false, false);
    }

    /**
     * Method name.
     *
     * @return [type] [description]
     *
     * @category Declarations
     */
    public function microDeclaration($highlight = true, $withLink = true, $showKeywords = true)
    {
        $base = $this->miniDeclaration($highlight, $withLink);
        $replace = [
            '>abstract<',
            'static',
            'final',
            'private',
            'protected',
            'public',
            'function',
            'class'
        ];

        $with = [
            '><',
            '',
            '',
            '',
            '',
            '',
            '',
            ''
        ];
        if ($showKeywords) {
            $with = [
                '>abs<',
                'stat',
                'fin',
                'priv',
                'prot',
                'pub',
                'func',
                'class'
            ];

        }

        return str_replace($replace, $with, $base);
    }
}
