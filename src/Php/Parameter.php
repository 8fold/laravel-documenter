<?php

namespace Eightfold\DocumentorLaravel\Php;

use phpDocumentor\Reflection\FunctionReflector\ArgumentReflector;

use Eightfold\DocumentorLaravel\Php\Method;

use Eightfold\DocumentorLaravel\Traits\Nameable;
use Eightfold\DocumentorLaravel\Traits\DocBlockable;
use Eightfold\DocumentorLaravel\Traits\Parameterized;

class Parameter extends ArgumentReflector
{
    use Nameable,
        DocBlockable,
        Parameterized;

    public $project = null;

    private $method = null;

    public function __construct(Method $method, ArgumentReflector $reflector)
    {
        $this->method = $method;
        $this->project = $this->method->class->project;
        $this->reflector = $reflector;
        $this->node = $this->reflector->getNode();
        $this->context = $this->reflector->context;
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
}
