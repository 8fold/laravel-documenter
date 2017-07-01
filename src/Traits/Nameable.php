<?php

namespace Eightfold\DocumentorLaravel\Traits;

use Eightfold\DocumentorLaravel\Php\Class_;
use Eightfold\DocumentorLaravel\Php\Trait_;
use Eightfold\DocumentorLaravel\Php\Interface_;
use Eightfold\DocumentorLaravel\Php\Parameter;

trait Nameable
{
    public function name($withLink = false)
    {
        if (is_a($this, Class_::class) || is_a($this, Trait_::class) || is_a($this, Interface_::class)) {
            return ($withLink)
                ? '<a href="'. $this->url() .'">'. $this->reflector->getShortName() .'</a>'
                : $this->reflector->getShortName();
        }
        return ($withLink)
            ? '<a href="'. $this->url() .'">'. $this->reflector->getName() .'</a>'
            : $this->reflector->getName();
    }

    public function longName()
    {
        return implode('\\', $this->node->namespacedName->parts);
    }
}
