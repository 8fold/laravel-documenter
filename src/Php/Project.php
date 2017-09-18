<?php

namespace Eightfold\DocumenterLaravel\Php;

use Illuminate\Support\Facades\View;

use Eightfold\DocumenterPhp\Project as phpProject;

class Project extends phpProject
{
    /**
     * When a user selects a project (not a version), use this view.
     *
     * The default order check:
     * - a directory within your /views/documenter directory named the project slug.
     *   ex. /views/documenter/[project-slug]. The directory has an overview.blade.php
     *   file within it.
     * - a documenterProjectOverview.blade.php template in your /views/documenter
     *   directory.
     * - a documenterProjectOverview.blade.php template in your /views directory, which
     *   is the default Laravel behavior.
     * - redirect to the version of the project with the highest version number.
     *
     * @return [type] [description]
     */
    public function viewForProjectOverview()
    {
        $return = [];
        $return['redirect'] = false;
        if (View::exists('documenter.'. $this->slug)) {
            $return['name'] = 'documenter.'. $this->slug;

        } elseif (View::exists('documenter.projectOverview')) {
            $return['name'] = 'documenter.projectOverview';

        } elseif (View::exists('documenter::projectOverview')) {
            $return['name'] = 'documenter::projectOverview';

        } else {
            $return['redirect'] = true;
            $return['name'] = $this->versionWithSlug($this->highestVersionSlug)->url;

        }
        return (object) $return;
    }
}
