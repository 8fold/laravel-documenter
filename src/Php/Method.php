<?php

namespace Eightfold\Documenter\Php;

use phpDocumentor\Reflection\ClassReflector\MethodReflector;

use Eightfold\Documenter\Php\File;
use Eightfold\Documenter\Php\DocBlock;
use Eightfold\Documenter\Php\Class_;
use Eightfold\Documenter\Php\Trait_;
use Eightfold\Documenter\Php\Interface_;
use Eightfold\Documenter\Php\Parameter;

use Eightfold\Documenter\Interfaces\HasDeclarations;

use Eightfold\Documenter\Traits\DocBlockable;
use Eightfold\Documenter\Traits\Nameable;
use Eightfold\Documenter\Traits\HasDeclarationsTrait;
use Eightfold\Documenter\Traits\DeclaredByClass;
use Eightfold\Documenter\Traits\CanBeAbstract;
use Eightfold\Documenter\Traits\CanBeFinal;
use Eightfold\Documenter\Traits\CanHaveAccess;
use Eightfold\Documenter\Traits\CanBeStatic;
use Eightfold\Documenter\Traits\Parameterized;

class Method extends MethodReflector
{
    use DocBlockable,
        Nameable,
        HasDeclarationsTrait,
        DeclaredByClass,
        CanBeAbstract,
        CanBeFinal,
        CanBeStatic,
        CanHaveAccess,
        Parameterized;

    public $project = null;

    public $class = null;

    private $reflector = null;

    private $url = '';

    private $parameters = [];

    private $returnTypes = '';

    private $returnDescription = '';

    public function __construct($class, MethodReflector $reflector)
    {
        $this->class = $class;
        $this->project = $this->class->project;
        $this->reflector = $reflector;
        $this->node = $this->reflector->getNode();
        $this->context = $this->reflector->context;
        $this->docBlock = new DocBlock($this, $this->node, $this->reflector->context, null);
    }

    public function url()
    {
        if (strlen($this->url) == 0) {
            $slug = kebab_case($this->node->name);
            $this->url = $this->class->url() .'/methods/'. $slug;
        }
        return $this->url;
    }

    public function parameters()
    {
        $parameters = $this->reflector->getArguments();
        if (count($this->parameters) == 0) {
            foreach($parameters as $parameter) {
                $this->parameters[] = new Parameter($this, $parameter);
            }
        }
        return $this->parameters;
    }

    /**
     * Whether the method returns something.
     *
     * @return boolean The count of return elements is greater than zero.
     *
     * @category Check method details
     */
    public function hasReturn()
    {
        if (!is_null($this->docBlock())) {
            return count($this->docBlock()->getTagsByName('return'));
        }

        return false;
    }

    public function returnTypes($withLink = false)
    {
        return $this->typeString('return', $withLink);
    }

    /**
     * @todo Combine link building logic with Parameter
     *
     * @return [type] [description]
     */
    public function returnDescription()
    {
        if (strlen($this->returnDescription) == 0) {
            $returnTag = $this->docBlock()->getTagsByName('return')[0];
            $this->returnDescription = $returnTag->getDescription();
        }
        return $this->returnDescription;
    }

    private function processDeclaration($highlight, $withLink)
    {
        if ($withLink) {
            $build[] = '<a class="call-signature" href="'. url($this->url()) .'">';
        }

        $build[] = $this->processOpening($highlight);

        $build[] = ($this->hasReturn())
            ? $this->name() .'('. $this->processParameters($highlight) .'): '. $this->getHighlightedString($this->returnTypes($withLink), 'typehint')
            : $this->name() .'('. $this->processParameters($highlight) .')';

        $build[] = ($withLink)
            ? '</a>'
            : '';

        return implode(' ', $build);
    }

    private function processOpening($highlight)
    {
        $build = [];

        $this->getFinalKeyword($highlight, $build);
        $this->getAbstractKeyword($highlight, $build);
        $this->getStaticKeyword($highlight, $build);
        $this->getAccessKeyword($highlight, $build);

        $build[] = $this->getHighlightedString('function');

        return implode(' ', $build);
    }

    private function processParameters($highlight)
    {
        if (count($this->parameters()) == 0) {
            return;
        }

        $params = [];
        foreach ($this->parameters() as $parameter) {
            $params[] = $this->getParameterStringTODO($parameter);
        }
        return implode(', ', $params);
    }

    /**
     * @todo Promote to superclass, or make trait.
     *
     * @param  [type] $label     [description]
     * @param  [type] $elemClass [description]
     * @return [type]            [description]
     */
    private function getHighlightedString($label, $elemClass = null)
    {
        return (is_null($elemClass))
            ? '<span class="'. $label .'">'. $label .'</span>'
            : '<span class="'. $elemClass .'">'. $label .'</span>';
    }

    /**
     * By default will be highlighted, have link, show interfaces, show traits, and
     * whether class is abstract or concrete.
     *
     * @param  boolean $highlight Default is true. Whether to display the highlights.
     * @param  boolean $withLink  Default is true. Whether to create an anchor tag.
     *
     * @return string             string|html Based on configuration.
     */
    public function largeDeclaration($highlight = true, $withLink = true)
    {
        return $this->processDeclaration($highlight, $withLink);
    }

    /**
     * Method name, parameters, type hints, defaults, function keyword, return type, and access level.
     *
     * @return string             string|html Based on configuration.
     */
    public function mediumDeclaration($highlight = true, $withLink = true)
    {
        return $this->buildDeclaration([
            'objectType'          => 'function',
            'highlight'           => $highlight,
            'withLink'            => $withLink,
            'showFunctionKeyword' => true,
            'showStaticKeyword'   => true,
            'showParameters'      => true,
            'showTypeHint'        => false,
            'showDefault'         => false,
            'showAccessKeyword'   => true,
            'showReturnType'      => true,
            'showFinalKeyword'    => true,
            'showAbstractKeyword' => true
        ]);
    }

    /**
     * Method name, parameters, type hints, defaults, and function keyword.
     *
     * @return string             string|html Based on configuration.
     */
    public function smallDeclaration($highlight = true, $withLink = true)
    {
        return $this->buildDeclaration([
            'objectType'          => 'function',
            'highlight'           => $highlight,
            'withLink'            => $withLink,
            'showFunctionKeyword' => true,
            'showStaticKeyword'   => true,
            'showParameters'      => false,
            'showTypeHint'        => false,
            'showDefault'         => false,
            'showAccessKeyword'   => true,
            'showReturnType'      => true,
            'showFinalKeyword'    => true,
            'showAbstractKeyword' => true
        ]);
    }

    /**
     * Method name, parameters.
     *
     * @return string             string|html Based on configuration.
     */
    public function miniDeclaration($highlight = true, $withLink = true)
    {
        return $this->buildDeclaration([
            'objectType'          => 'function',
            'highlight'           => $highlight,
            'withLink'            => $withLink,
            'showFunctionKeyword' => true,
            'showStaticKeyword'   => true,
            'showParameters'      => false,
            'showTypeHint'        => false,
            'showDefault'         => false,
            'showAccessKeyword'   => true,
            'showReturnType'      => false,
            'showFinalKeyword'    => true,
            'showAbstractKeyword' => true
        ]);
    }

    /**
     * Method name.
     *
     * @return string             string|html Based on configuration.
     */
    public function microDeclaration($highlight = true, $withLink = true, $showKeywords = true)
    {
        $base = $this->buildDeclaration([
            'objectType'          => 'function',
            'highlight'           => $highlight,
            'withLink'            => $withLink,
            'showFunctionKeyword' => true,
            'showStaticKeyword'   => true,
            'showParameters'      => false,
            'showTypeHint'        => false,
            'showDefault'         => false,
            'showAccessKeyword'   => true,
            'showReturnType'      => false,
            'showFinalKeyword'    => true,
            'showAbstractKeyword' => true
        ]);
        $replace = ['>abstract<', 'static', 'final', 'private', 'protected', 'public', 'function'];
        $with = ['>abs<', 'stat', 'fin', 'priv', 'prot', 'pub', 'func'];
        return str_replace($replace, $with, $base);
    }
}
