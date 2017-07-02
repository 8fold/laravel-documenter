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
        $parentClass = $this->project->objectWithLongName($parentNamespace);
        if (is_null($parentClass)) {
            return new ClassExternal($parentNamespaceParts);

        }
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
