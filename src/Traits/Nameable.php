<?php

namespace Eightfold\Documenter\Traits;

use Eightfold\Documenter\Php\Class_;
use Eightfold\Documenter\Php\Trait_;
use Eightfold\Documenter\Php\Interface_;
use Eightfold\Documenter\Php\Parameter;

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
        return implode('\\', $this->reflector->getNode()->namespacedName->parts);
    }
}
