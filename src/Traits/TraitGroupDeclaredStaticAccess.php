<?php

namespace Eightfold\Documenter\Traits;

use Eightfold\Documenter\Traits\DeclaredByClass;
use Eightfold\Documenter\Traits\CanBeStatic;
use Eightfold\Documenter\Traits\CanHaveAccess;

trait TraitGroupDeclaredStaticAccess
{
    use DeclaredByClass,
        CanBeStatic,
        CanHaveAccess;
}
