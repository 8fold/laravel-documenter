<?php

namespace Eightfold\DocumentorLaravel\Traits;

trait DeclaredByClass
{
    public function declaredBy()
    {
        return $this->class;
    }
}
