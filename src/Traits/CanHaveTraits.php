<?php

namespace Eightfold\Documenter\Traits;

trait CanHaveTraits
{
    /**
     * [traits description]
     * @return [type] [description]
     *
     * @category Modifiers
     */
    public function traits()
    {
        $reflectorTraits = $this->reflector->getTraits();
        if (count($reflectorTraits) == 0) {
            return [];

        }

        if (count($this->traits) == 0) {
            $return = [];
            foreach ($reflectorTraits as $longName) {
                $return[] = $this->project->objectWithLongName($longName);

            }
            $this->traits = $return;

        }
        return $this->traits;
    }
}
