<?php

namespace Eightfold\Documenter\Php;

use phpDocumentor\Reflection\ClassReflector\PropertyReflector;

use Eightfold\Documenter\Php\Class_;

use Eightfold\Documenter\Interfaces\HasDeclarations;

use Eightfold\Documenter\Traits\TraitGroupDocNameParam;
use Eightfold\Documenter\Traits\TraitGroupDeclaredStaticAccess;

// use Eightfold\Documenter\Traits\CanBeStatic;
// use Eightfold\Documenter\Traits\CanHaveAccess;
// use Eightfold\Documenter\Traits\DeclaredByClass;
use Eightfold\Documenter\Traits\HighlightableString;

/**
 * @category Symbols
 */
class Property extends PropertyReflector implements HasDeclarations
{
    use TraitGroupDocNameParam,
        TraitGroupDeclaredStaticAccess,
        HighlightableString;

    public $project = null;

    /**
     * @todo Rename to object - can be class or trait
     *
     * @var null
     */
    private $class = null;

    private $reflector = null;

    private $url = '';

    public function __construct($class, PropertyReflector $reflector)
    {
        $this->class = $class;
        $this->project = $class->project;
        $this->reflector = $reflector;
        $this->node = $this->reflector->getNode();
    }

    public function url()
    {
        if (strlen($this->url) == 0) {
            $slug = kebab_case($this->node->name);
            $this->url = $this->class->url() .'/properties/'. $slug;
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
    private function processDeclaration($highlight, $withLink)
    {
        if ($withLink) {
            $build[] = '<a class="call-signature" href="'. url($this->url()) .'">';
        }

        $build[] = $this->processOpening($highlight);

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

        if ($this->isStatic()) {
            $build[] = $this->getHighlightedString('static');
        }

        $build[] = $this->getHighlightedString($this->access(), 'access');

        $build[] = $this->name();

        return implode(' ', $build);
    }

    /**
     * By default will be highlighted, have link, show interfaces, show traits, and
     * whether class is abstract or concrete.
     *
     * @param  boolean $highlight Default is true. Whether to display the highlights.
     * @param  boolean $withLink  Default is true. Whether to create an anchor tag.
     * @return [type]             [description]
     */
    public function largeDeclaration($highlight = true, $withLink = true)
    {
        return $this->processDeclaration($highlight, $withLink);
    }

    /**
     * Method name, parameters, type hints, defaults, function keyword, return type, and access level.
     *
     * @return [type] [description]
     */
    public function mediumDeclaration($highlight = true, $withLink = true)
    {
        return $this->processDeclaration($highlight, $withLink);
    }

    /**
     * Method name, parameters, type hints, defaults, and function keyword.
     *
     * @return [type] [description]
     */
    public function smallDeclaration($highlight = true, $withLink = true)
    {
        return $this->processDeclaration($highlight, $withLink);
    }

    /**
     * Method name, parameters.
     *
     * @return [type] [description]
     */
    public function miniDeclaration($highlight = true, $withLink = true)
    {
        return $this->processDeclaration($highlight, $withLink);
    }

    /**
     * Method name.
     *
     * @return [type] [description]
     */
    public function microDeclaration($highlight = true, $withLink = true, $showKeywords = true)
    {
        $base = $this->processDeclaration($highlight, $withLink);
        $replace = [
            '>abstract<',
            'static',
            'final',
            'private',
            'protected',
            'public',
            'function'
        ];

        $with = [
            '>abs<',
            'stat',
            'fin',
            'priv',
            'prot',
            'pub',
            'func'
        ];

        return str_replace($replace, $with, $base);
    }
}
