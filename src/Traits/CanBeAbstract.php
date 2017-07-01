<?php

namespace Eightfold\DocumentorLaravel\Traits;

trait CanBeAbstract
{
    public function isAbstract()
    {
        return $this->node->isAbstract();
    }

    private function getAbstractKeyword($highlight, &$build)
    {
        if ($this->isAbstract()) {
            $build[] = $this->getHighlightedString('abstract');

        }
    }
}
