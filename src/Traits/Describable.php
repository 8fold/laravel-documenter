<?php

namespace Eightfold\Documenter\Traits;

trait Describable
{
    public function shortDescription()
    {
        return static::prepareForMarkdown($this->raw->shortDescription);
    }

    public function description()
    {
        dd($this->docBlock());
        if (isset($this->raw->longDescription)) {
            return static::prepareForMarkdown($this->raw->longDescription);
        }
        return $this->raw->description;
    }

    public function deprecatedDescription()
    {
        if (isset($this->raw->deprecatedDescription) && strlen($this->raw->deprecatedDescription) > 0) {
            return static::prepareForMarkdown($this->raw->deprecatedDescription);
        }
        return '';
    }
}
