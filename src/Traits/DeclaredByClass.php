<?php

namespace Eightfold\Documenter\Traits;

trait DeclaredByClass
{
    public function declaredBy()
    {
        return $this->class;
    }
}
