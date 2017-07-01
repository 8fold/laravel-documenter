<?php

namespace Eightfold\Documenter\Traits;

use \View;

trait DocumentorViewFinder
{
    public function viewForProjectOverview()
    {
        return $this->viewFinder('overview');
    }

    public function viewForHome()
    {
        return $this->viewFinder('version.home');
    }

    public function viewForObject($object)
    {
        switch (get_class($object)) {
            case 'Eightfold\Documenter\Php\Interface_':
                return $this->viewFinder('version.interface');
                break;

            case 'Eightfold\Documenter\Php\Trait_':
                return $this->viewFinder('version.trait');
                break;

            default:
                return $this->viewFinder('version.class');
                break;
        }
    }

    // public function viewForProjectClass($projectClass)
    // {
    //     return $this->viewFinder('version.class');
    // }

    // public function viewForProjectTrait($projectTrait)
    // {
    //     return $this->viewFinder('version.trait');
    // }

    public function viewForMethod($method)
    {
        return $this->viewFinder('version.method');
    }

    public function viewForProperty($property)
    {
        return $this->viewFinder('version.property');
    }

    // public function viewForTrait()
    // {
    //     return $this->viewFinder('version.trait');
    // }

    // public function viewForInterface()
    // {
    //     return $this->viewFinder('version.interface');
    // }

    public function viewForTitle()
    {
        return $this->viewFinder('partials.title');
    }

    /**
     * @todo Project specific in the user's /resources/views/project folder.
     *
     * @param  [type] $viewStandardName [description]
     * @return [type]                   [description]
     */
    private function viewFinder($viewStandardName)
    {
        // Project specific, withing documenter
        if ($this->viewExists($viewStandardName)) {
            return 'documenter::'. $this->slug .'.'. $viewStandardName;
        }
        // Provider specific
        return 'documenter::'. $viewStandardName;
    }

    public function viewExists($viewStandardName)
    {
        return View::exists('documenter::'. $this->slug .'.'. $viewStandardName);
    }
}
