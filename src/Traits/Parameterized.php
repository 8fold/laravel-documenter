<?php

namespace Eightfold\Documenter\Traits;

use Eightfold\Documenter\Php\DocBlock;

trait Parameterized
{
    // private $typeHintTODO = null;

    // public function defaultValue()
    // {
    //     return ($this->hasDefault())
    //         ? $this->reflector->getDefault()
    //         : '';
    // }

    // public function hasDefault()
    // {
    //     return (strlen($this->reflector->getDefault()) > 0);
    // }

    /**
     * @todo Shouldn't have to pass the parameter in, should only be used by parameter
     * or property
     *
     * @param  [type]  $parameter   [description]
     * @param  boolean $highlight   [description]
     * @param  boolean $showDefault [description]
     * @return [type]               [description]
     */
    // private function getParameterStringTODO($parameter, $highlight = true, $showDefault = true)
    // {
    //     $typeHint = $this->typeHintTODO($parameter);

    //     $build = [];
    //     if (!is_null($typeHint) && strlen($typeHint->type) > 0) {
    //         $build[] = $this->getHighlightedString($typeHint->type, 'typehint');

    //     }

    //     $build[] = $this->getHighlightedString($parameter->name(), 'parameter');

    //     if ($parameter->hasDefault()) {
    //         $build[] = '=';
    //         $build[] = $parameter->defaultValue();
    //     }

    //     return implode(' ', $build);
    // }

    // public function typeHintTODO($parameter)
    // {
    //     $project = $this->project;

    //     // Has inline typehint established
    //     $types = [];
    //     if (!is_null($parameter->reflector->getType()) && strlen($parameter->reflector->getType()) > 0) {
    //         $types[] = $parameter->reflector->getType();

    //     } elseif (!is_null($this->docBlock())) {
    //         $docBlockReference = $this->getDocBlockParamTagWithVariableName($parameter->name(), $this->docBlock());
    //         if (is_null($docBlockReference)) {
    //             return null;
    //         }
    //         $types = explode('|', $docBlockReference->getType());

    //     }

    //     $return = null;
    //     foreach ($types as $type) {
    //         if ($project->hasClass($type)) {
    //             $class = $project->objectWithLongName($type);
    //             $build = [];
    //             $build['url'] = $class->url();
    //             $build['type'] = $class->getShortname();
    //             $return = (object) $build;

    //         } else {
    //             $build = [];
    //             $build['url'] = null;
    //             $build['type'] = str_replace($project->space() .'\\', '', ltrim($type, '\\'));
    //             $return = (object) $build;

    //         }
    //     }
    //     return $return;
    // }

    // private function getDocBlockParamTagWithVariableName($name, $docBlock)
    // {
    //     $params = $docBlock->getTagsByName('param');
    //     $paramTag = null;
    //     foreach ($params as $param) {
    //         if ($param->getVariableName() == $name) {
    //             $paramTag = $param;
    //         }
    //     }
    //     return $paramTag;
    // }
}
