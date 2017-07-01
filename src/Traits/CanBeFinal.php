<?php

namespace Eightfold\DocumentorLaravel\Traits;

trait CanBeFinal
{
    /**
     * Whether the method is a class or instance method.
     *
     * @return boolean [description]
     *
     * @category Check method details
     */
    public function isFinal()
    {
        return $this->node->isFinal();
    }

    private function getFinalKeyword($highlight, &$build)
    {
        if ($this->isFinal()) {
            $build[] = $this->getHighlightedString('final');

        }
    }
}
