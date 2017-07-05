<?php

namespace Eightfold\Documenter\Traits;

use Eightfold\Documenter\Php\ClassExternal;

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
        if ($parentClass = $this->project->objectWithLongName($parentNamespace)) {
            return $parentClass;
        }
        return new ClassExternal($parentNamespaceParts);
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

    // public function inheritance()
    // {
    //     return $this->parentRecursive($this);
    // }
}
