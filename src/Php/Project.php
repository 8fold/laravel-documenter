<?php

namespace Eightfold\DocumenterLaravel\Php;

use Eightfold\DocumenterPhp\Project as phpProject;

class Project extends phpProject
{
    /**
     * The title to display for the project.
     *
     * @return String The title for the project established in the configuration.
     *
     * @category Display
     *
     */
    static public function titleFromSlug($slug)
    {
        $allTitles = config('documenter-laravel.project_titles');
        if (array_key_exists($slug, $allTitles)) {
            return $allTitles[$slug];

        }
        return 'Project name unknown';
    }

    /**
     * @return String Calls static method titleFromSlug()
     */
    public function title()
    {
        return Project::titleFromSlug($this->projectSlug());
    }

    public function viewForHome()
    {
        return 'documenter::version.home';
    }

    public function viewForObject($object)
    {
        switch (get_class($object)) {
            case 'Eightfold\Documenter\Php\Interface_':
                return 'documenter::version.interface';
                break;

            case 'Eightfold\Documenter\Php\Trait_':
                return 'documenter::version.trait';
                break;

            default:
                return 'documenter::version.class';
                break;
        }
    }

    public function viewForMethod($method)
    {
        return 'documenter::version.method';
    }

    public function viewForProperty($property)
    {
        return 'documenter::version.property';
    }
}
