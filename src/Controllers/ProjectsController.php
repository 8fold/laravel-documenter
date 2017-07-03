<?php

namespace Eightfold\Documenter\Controllers;

use App\Http\Controllers\Controller;

use \DirectoryIterator;

use Eightfold\Documenter\Php\Project as phpProject;

class ProjectsController extends Controller
{
    /**
     * Cache of all projects found inside the projects root directory.
     *
     * @var array
     */
    private $projects = [];

    /**
     * Cache of all versions for a project, used only for the count.
     *
     * @var array
     */
    private $versions = [];

    /**
     * Prepare to view a list of all projects.
     *
     * @return [type] [description]
     */
    public function index()
    {
        return view('documenter::overview')
            ->with('projects', $this->projects());
    }

    /**
     * Prepare to view a specific project.
     *
     * @param  [type] $projectSlug [description]
     * @return [type]              [description]
     */
    public function viewProjectOverview($projectSlug)
    {
        $project = new phpProject($projectSlug);
        if ($project->viewExists('overview')) {
            return $this->baseViewWith($project, $project->viewForProjectOverview());

        }
        $versions = $project->versions();
        return redirect(url($projectSlug .'/'. $versions[0]));
    }

    /**
     * Prepare view for a specific project version.
     *
     * @param  [type] $project_slug [description]
     * @param  [type] $version_slug [description]
     * @return [type]               [description]
     */
    public function viewProjectVersion($projectSlug, $versionSlug)
    {
        $project = new phpProject('/'. $projectSlug .'/'. $versionSlug);
        $classes = $project->classesOrdered();
        $traits = $project->traitsOrdered();
        $interfaces = $project->interfaces();
        return $this->viewWithVersion($project, $project->viewForHome(), $versionSlug)
            ->with('classesOrdered', $classes)
            ->with('traitsOrdered', $traits)
            ->with('interfaces', $interfaces);
    }

    /**
     * Prepare to view a class, trait, or interface within the project.
     *
     * @param  [type] $projectSlug [description]
     * @param  [type] $versionSlug [description]
     * @param  [type] $all         [description]
     * @return [type]              [description]
     */
    public function viewObject($projectSlug, $versionSlug, $all)
    {
        $project = new phpProject('/'. $projectSlug .'/'. $versionSlug);
        return $this->viewWithSymbols($project, $versionSlug, $all);
    }

    /**
     * Prepare to view a method within a class, trait, or interface.
     *
     * @param  [type] $projectSlug [description]
     * @param  [type] $versionSlug [description]
     * @param  [type] $all         [description]
     * @param  [type] $method_name [description]
     * @return [type]              [description]
     */
    public function viewMethod($projectSlug, $versionSlug, $all, $method_name)
    {
        $project = new phpProject('/'. $projectSlug .'/'. $versionSlug);
        $class = $project->objectWithPath($all);
        $method = $class->methodWithSlug($method_name);

        $view = $this->viewWithSymbols($project, $versionSlug, $all, $project->viewForMethod($method));

        // TODO: Remove need for "class"
        return $view
            ->with('class', $class)
            ->with('method', $method);
    }

    /**
     * Prepare to view a property wtihin a class or trait.
     *
     * @param  [type] $projectSlug  [description]
     * @param  [type] $versionSlug  [description]
     * @param  [type] $all          [description]
     * @param  [type] $propertyName [description]
     * @return [type]               [description]
     */
    public function viewProperty($projectSlug, $versionSlug, $all, $propertyName)
    {
        $project = new phpProject('/'. $projectSlug .'/'. $versionSlug);
        $class = $project->objectWithPath($all);
        $property = $class->propertyWithSlug($propertyName);

        $view = $this->viewWithSymbols($project, $versionSlug, $all, $project->viewForProperty($property));

        // TODO: Remove need for class
        return $view
            ->with('class', $class)
            ->with('property', $property);
    }

    /**
     * Get projects and versions from the config projects root.
     *
     * @return [type] [description]
     *
     * @category Utilities
     */
    private function projects()
    {
        if (count($this->projects) > 0) {
            return $this->projects;
        }
        $projects = [];
        $dirPath = config('documenter-laravel.projects_root');
        if (file_exists($dirPath)) {
            $directory = new DirectoryIterator($dirPath);
            foreach ($directory as $projectFileInfo) {
                if ($projectFileInfo->isDir() && !$projectFileInfo->isDot()) {
                    $projectPath = $projectFileInfo->getFilename();
                    $projectDir = new DirectoryIterator($projectFileInfo->getPathname());
                    foreach ($projectDir as $versionFileInfo) {
                        if ($versionFileInfo->isDir() && !$versionFileInfo->isDot()) {
                            $versionPath = $versionFileInfo->getFilename();
                            $path = '/'. $projectPath .'/'. $versionPath;
                            $projects[$projectPath][] = new phpProject($path);
                        }
                    }
                }
            }
        }
        $this->projects = $projects;

        return $this->projects;
    }

    /**
     * Get versions for a specified project.
     *
     * @param  [type] $projectSlug [description]
     * @return [type]              [description]
     *
     * @category Utilities
     */
    private function versions($projectSlug)
    {
        $projects = $this->projects();
        if (count($this->versions) == 0 && isset($projects[$projectSlug])) {
            return $projects[$projectSlug];

        }
        return [];
    }

    /**
     * Prepare universal view with required paramaters for navigation and whatnot.
     *
     * @param  [type] $project  [description]
     * @param  [type] $viewName [description]
     * @return [type]           [description]
     *
     * @category Utilities
     */
    private function baseViewWith($project, $viewName)
    {
        return view($viewName)
            ->with('project_slug', $project->slug())
            ->with('projects', $this->projects())
            ->with('project', $project)
            ->with('project_namespace', $project->space());
    }

    /**
     * Prepare for a specific project version. (duplicate??)
     *
     * @param  [type] $project     [description]
     * @param  [type] $viewName    [description]
     * @param  [type] $versionSlug [description]
     * @return [type]              [description]
     *
     * @category Utilities
     */
    private function viewWithVersion($project, $viewName, $versionSlug)
    {
        $base = $this->baseViewWith($project, $viewName);
        return $base
            ->with('version', str_replace('-', '.', $versionSlug))
            ->with('project_versions', $this->versions($project->slug()));
    }

    /**
     * Prepare to view a specific class, trait, or interface.
     *
     * @param  [type] $project     [description]
     * @param  [type] $versionSlug [description]
     * @param  [type] $all         [description]
     * @param  [type] $laravelView [description]
     * @return [type]              [description]
     */
    private function viewWithSymbols($project, $versionSlug, $all, $laravelView = null)
    {
        $object = $project->objectWithPath($all);
        $view = $project->viewForObject($object);
        if (!is_null($laravelView)) {
            $view = $laravelView;
        }

        $view = $this->viewWithVersion($project, $view, $versionSlug)
            ->with('object', $object)
            ->with('symbols', $object->symbolsOrdered());

        if (get_class($object) == 'Eightfold\Documenter\Php\Class_' || get_class($object) == 'Eightfold\Documenter\Php\Trait_') {
            $view->with('traits', $object->traits());
        }
        return $view;
    }
}
