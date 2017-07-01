<?php

namespace Eightfold\DocumentorLaravel\Php;

use phpDocumentor\Reflection\ClassReflector\PropertyReflector;

use Eightfold\DocumentorLaravel\Php\Class_;

use Eightfold\DocumentorLaravel\Interfaces\HasDeclarations;

use Eightfold\DocumentorLaravel\Traits\DocBlockable;
use Eightfold\DocumentorLaravel\Traits\Nameable;
use Eightfold\DocumentorLaravel\Traits\CanBeStatic;
use Eightfold\DocumentorLaravel\Traits\CanHaveAccess;
use Eightfold\DocumentorLaravel\Traits\Parameterized;
use Eightfold\DocumentorLaravel\Traits\DeclaredByClass;
use Eightfold\DocumentorLaravel\Traits\HasDeclarationsTrait;

class Property extends PropertyReflector implements HasDeclarations
{
    use DocBlockable,
        Nameable,
        CanBeStatic,
        CanHaveAccess,
        Parameterized,
        DeclaredByClass,
        HasDeclarationsTrait;

    public $project = null;

    private $class = null;

    private $reflector = null;

    private $url = '';

    public function __construct(Class_ $class, PropertyReflector $reflector)
    {
        $this->class = $class;
        $this->project = $class->project;
        $this->reflector = $reflector;
        $this->node = $this->reflector->getNode();
        $this->context = $this->reflector->context;
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
     * By default will be highlighted, have link, show interfaces, show traits, and
     * whether class is abstract or concrete.
     *
     * @param  boolean $highlight Default is true. Whether to display the highlights.
     * @param  boolean $withLink  Default is true. Whether to create an anchor tag.
     * @return [type]             [description]
     */
    public function largeDeclaration($highlight = true, $withLink = true)
    {
        return $this->buildDeclaration([
            'objectType'          => 'property',
            'highlight'           => $highlight,
            'withLink'            => $withLink,
            'showStaticKeyword'   => true,
            'showDefault'         => true,
            'showAccessKeyword'   => true,
            'showTypeHint'        => true,
            'showReturnType'      => true,
            'showAbstractKeyword' => true
        ]);
    }

    /**
     * Method name, parameters, type hints, defaults, function keyword, return type, and access level.
     *
     * @return [type] [description]
     */
    public function mediumDeclaration($highlight = true, $withLink = true)
    {
        return $this->buildDeclaration([
            'objectType'          => 'property',
            'highlight'           => $highlight,
            'withLink'            => $withLink,
            'showStaticKeyword'   => true,
            'showDefault'         => false,
            'showAccessKeyword'   => true,
            'showTypeHint'        => true,
            'showReturnType'      => true,
            'showAbstractKeyword' => true
        ]);
    }

    /**
     * Method name, parameters, type hints, defaults, and function keyword.
     *
     * @return [type] [description]
     */
    public function smallDeclaration($highlight = true, $withLink = true)
    {
        return $this->buildDeclaration([
            'objectType'          => 'property',
            'highlight'           => $highlight,
            'withLink'            => $withLink,
            'showStaticKeyword'   => true,
            'showDefault'         => false,
            'showAccessKeyword'   => true,
            'showTypeHint'        => false,
            'showReturnType'      => true,
            'showAbstractKeyword' => true
        ]);
    }

    /**
     * Method name, parameters.
     *
     * @return [type] [description]
     */
    public function miniDeclaration($highlight = true, $withLink = true)
    {
        return $this->buildDeclaration([
            'objectType'          => 'property',
            'highlight'           => $highlight,
            'withLink'            => $withLink,
            'showStaticKeyword'   => true,
            'showDefault'         => false,
            'showAccessKeyword'   => true,
            'showTypeHint'        => false,
            'showReturnType'      => false,
            'showAbstractKeyword' => true,
        ]);
    }

    /**
     * Method name.
     *
     * @return [type] [description]
     */
    public function microDeclaration($highlight = true, $withLink = true, $showKeywords = true)
    {
        $base = $this->buildDeclaration([
            'objectType'          => 'property',
            'highlight'           => $highlight,
            'withLink'            => $withLink,
            'showStaticKeyword'   => true,
            'showDefault'         => false,
            'showAccessKeyword'   => true,
            'showTypeHint'        => false,
            'showReturnType'      => false,
            'showAbstractKeyword' => true
        ]);
        $replace = ['>abstract<', 'static', 'final', 'private', 'protected', 'public', 'function'];
        $with = ['>abs<', 'stat', 'fin', 'priv', 'prot', 'pub', 'func'];
        return str_replace($replace, $with, $base);
    }
}
