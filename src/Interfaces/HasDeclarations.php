<?php

namespace Eightfold\Documenter\Interfaces;

interface HasDeclarations
{
    public function largeDeclaration($highlight = true, $withLink = true);
    public function mediumDeclaration($highlight = true, $withLink = true);
    public function smallDeclaration($highlight = true, $withLink = true);
    public function miniDeclaration($highlight = true, $withLink = true);
    public function microDeclaration($highlight = true, $withLink = true, $showKeywords = true);
}
