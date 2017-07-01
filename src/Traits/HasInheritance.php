<?php

namespace Eightfold\DocumentorLaravel\Traits;

use Eightfold\DocumentorLaravel\Models\ObjectClass;

trait HasInheritance
{
    public function parent()
    {
        $extends = null;
        if (is_null($this->node->extends)) {
            return null;
        }
        $parentNamespaceParts = $this->node->extends->parts;
        $parentNamespace = implode('\\', $parentNamespaceParts);
        $parentClass = $this->project->objectWithLongName($parentNamespace);
        return $parentClass;
    }

    private function parentRecursive($object, $objects = [])
    {
        $objects[] = $object;
        $parent = $object->parent();
        if (!is_null($parent)) {
            return $this->parentRecursive($parent, $objects);
        }
        return array_reverse($objects);
    }

    public function inheritance()
    {
        return $this->parentRecursive($this);
    }
}
