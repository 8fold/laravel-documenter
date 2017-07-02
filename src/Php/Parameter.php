<?php

namespace Eightfold\Documenter\Php;

use phpDocumentor\Reflection\FunctionReflector\ArgumentReflector;

use Eightfold\Documenter\Php\Method;

use Eightfold\Documenter\Traits\TraitGroupDocNameParam;

/**
 * @category Symbols
 */
class Parameter extends ArgumentReflector
{
    use TraitGroupDocNameParam;

    public $project = null;

    private $method = null;

    public function __construct(Method $method, ArgumentReflector $reflector)
    {
        $this->method = $method;
        $this->project = $this->method->class->project;
        $this->reflector = $reflector;
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
