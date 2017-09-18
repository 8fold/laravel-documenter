<?php

namespace Eightfold\DocumenterLaravel\Php;

use Illuminate\Support\Facades\View;

use Eightfold\DocumenterPhp\Version as phpVersion;

class Version extends phpVersion
{
    /**
     * When a user selects a project version, use this view.
     *
     * Default order check:
     * - a directory within your /views/documenter/[project-slug] directory named the
     *   version slug. ex. /views/documenter/[project-slug]/[version-slug]. The
     *   directory has a home.blade.php file within it.
     * - a directory within your /views/documenter/[project-slug] directory named
     *   "version". ex. /views/documenter/[project-slug]/version. The directory has a
     *   file named home.blade.php.
     * - the default home.blade.php in Documenter's /views/version directory.
     *
     * @return [type] [description]
     */
    public function viewForVersion()
    {
        return $this->versionView('home');
    }

    /**
     * When a user selects an object with a project version, use this view.
     *
     * Default order check:
     * - a directory within your /views/documenter/[project-slug] directory named the
     *   version slug. ex. /views/documenter/[project-slug]/[version-slug]. The
     *   directory has a object.blade.php file within it.
     * - a directory within your /views/documenter/[project-slug] directory named
     *   "version". ex. /views/documenter/[project-slug]/version. The directory has a
     *   file named object.blade.php.
     * - the default object.blade.php in Documenter's /views/version directory.
     *
     * @return [type] [description]
     */
    public function viewForObject($object)
    {
        return $this->versionView('object');
    }

    /**
     * When a user selects an object with a project version, use this view.
     *
     * Default order check:
     * - a directory within your /views/documenter/[project-slug] directory named the
     *   version slug. ex. /views/documenter/[project-slug]/[version-slug]. The
     *   directory has a method.blade.php file within it.
     * - a directory within your /views/documenter/[project-slug] directory named
     *   "version". ex. /views/documenter/[project-slug]/version. The directory has a
     *   file named method.blade.php.
     * - the default method.blade.php in Documenter's /views/version directory.
     *
     * @return [type] [description]
     */
    public function viewMethod($method)
    {
        return $this->versionView('method');
    }

    /**
     * When a user selects an object with a project version, use this view.
     *
     * Default order check:
     * - a directory within your /views/documenter/[project-slug] directory named the
     *   version slug. ex. /views/documenter/[project-slug]/[version-slug]. The
     *   directory has a property.blade.php file within it.
     * - a directory within your /views/documenter/[project-slug] directory named
     *   "version". ex. /views/documenter/[project-slug]/version. The directory has a
     *   file named property.blade.php.
     * - the default property.blade.php in Documenter's /views/version directory.
     *
     * @return [type] [description]
     */
    public function viewProperty()
    {
        return $this->versionView('property');
    }

    private function versionView($viewName)
    {
        if (View::exists('documenter.'. $this->project->slug .'.'. $this->slug .'.'. $viewName)) {
            return 'documenter.'. $this->project->slug .'.'. $this->slug .'.'. $viewName;

        } elseif (View::exists('documenter.'. $this->project->slug .'.version.'. $viewName)) {
            return 'documenter.'. $this->project->slug .'.version.'. $viewName;

        }
        return 'documenter::version.'. $viewName;
    }
}
