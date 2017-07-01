<?php

namespace Eightfold\DocumentorLaravel\Traits;

trait CanBeStatic
{
    /**
     * Whether the method is a class or instance method.
     *
     * @return boolean [description]
     *
     * @category Check method details
     */
    public function isStatic()
    {
        return $this->reflector->isStatic();
    }

    private function getStaticKeyword($highlight, &$build)
    {
        if ($this->isStatic()) {
            $build[] = $this->getHighlightedString('static');

        }
    }
}
