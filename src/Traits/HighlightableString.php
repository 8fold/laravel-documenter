<?php

namespace Eightfold\Documenter\Traits;

trait HighlightableString
{
    /**
     * [getHighlightedString description]
     * @param  [type] $label     [description]
     * @param  [type] $elemClass [description]
     * @return [type]            [description]
     *
     * @category Declarations
     */
    private function getHighlightedString($label, $elemClass = null)
    {
        return (is_null($elemClass))
            ? '<span class="'. $label .'">'. $label .'</span>'
            : '<span class="'. $elemClass .'">'. $label .'</span>';
    }
}
