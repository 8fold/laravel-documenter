<?php
// TODO: Maybe this is worth pursuing...??
//
// Class_
    public function url()
    {
        if (strlen($this->url) == 0) {
            $slugged = [];
            foreach ($this->node->namespacedName->parts as $part) {
                $slugged[] = kebab_case($part);
            }
            array_shift($slugged);
            array_shift($slugged);
            $thisPath = implode('/', $slugged);
            $this->url = $this->project->url() .'/'. $thisPath;
        }
        return $this->url;
    }

// Method
    public function url()
    {
        if (strlen($this->url) == 0) {
            $slug = kebab_case($this->node->name);
            $this->url = $this->class->url() .'/methods/'. $slug;
        }
        return $this->url;
    }

// Project
    public function url()
    {
        return $this->url;
    }

// Property
    public function url()
    {
        if (strlen($this->url) == 0) {
            $slug = kebab_case($this->node->name);
            $this->url = $this->class->url() .'/properties/'. $slug;
        }
        return $this->url;
    }

// Trait_

    public function url()
    {
        if (strlen($this->url) == 0) {
            $slugged = [];
            foreach ($this->node->namespacedName->parts as $part) {
                $slugged[] = kebab_case($part);
            }
            array_shift($slugged);
            array_shift($slugged);
            $thisPath = implode('/', $slugged);
            $this->url = $this->project->url() .'/'. $thisPath;
        }
        return $this->url;
    }
