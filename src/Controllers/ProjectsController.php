<?php

namespace Eightfold\DocumenterLaravel\Controllers;

use App\Http\Controllers\Controller;

use \DirectoryIterator;

use Eightfold\DocumenterLaravel\Php\Documenter;
use Eightfold\DocumenterLaravel\Php\Project;
use Eightfold\DocumenterLaravel\Php\Version;

class ProjectsController extends Controller
{
    /**
     * Cache of all projects found inside the projects root directory.
     *
     * @categoryDescription
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
     * Root
     *
     * @return [type] [description]
     */
    public function index()
    {
        return view($this->documenter()->viewForIndex())
            ->with('documenter', $this->documenter())
            ->with('projects', $this->documenter()->projects);
    }

    /**
     * Prepare view for a specific project version.
     *
     * /{project-slug}/{project-version}
     *
     * @param  [type] $project_slug [description]
     * @param  [type] $version_slug [description]
     * @return [type]               [description]
     */
    public function viewProjectVersion($projectSlug, $versionSlug)
    {
        $version = $this->version($projectSlug, $versionSlug);
        $classes = $version->classesCategorized();
        $traits = $version->traitsCategorized();
        $interfaces = $version->interfacesCategorized();
        return view($version->viewForVersion())
            ->with('documenter', $this->documenter())
            ->with('projects', $this->documenter()->projects)
            ->with('project', $version->project)
            ->with('project_slug', $projectSlug)
            ->with('version', $version)
            ->with('classesOrdered', $classes)
            ->with('traitsOrdered', $traits)
            ->with('interfacesOrdered', $interfaces);
    }

    /**
     * Prepare to view a class, trait, or interface within the project.
     *
     * /{project-slug}/{project-version}/{namespace-slug}/{object-slug}
     *
     * @param  [type] $projectSlug [description]
     * @param  [type] $versionSlug [description]
     * @param  [type] $all         [description]
     * @return [type]              [description]
     */
    public function viewObject($projectSlug, $versionSlug, $all)
    {
        $version = $this->version($projectSlug, $versionSlug);
        $classes = $version->classesCategorized();
        $traits = $version->traitsCategorized();
        $interfaces = $version->interfacesCategorized();
        $object = $version->objectWithPath($all);

        $view = view($version->viewForObject($object))
            ->with('documenter', $this->documenter())
            ->with('projects', $this->documenter()->projects)
            ->with('project', $version->project)
            ->with('version', $version)
            ->with('object', $object)
            ->with('symbols', $object->symbolsCategorized());

        if (get_class($object) == 'Eightfold\Documenter\Php\Class_' || get_class($object) == 'Eightfold\Documenter\Php\Trait_') {
            $view->with('traits', $object->traits());
        }
        return $view;
    }

    /**
     * Prepare to view a method within a class, trait, or interface.
     *
     * /{project-slug}/{project-version}
     * /{namespace-slug}/{object-slug}/methods/{method-slug}
     *
     * @param  [type] $projectSlug [description]
     * @param  [type] $versionSlug [description]
     * @param  [type] $all         [description]
     * @param  [type] $method_name [description]
     * @return [type]              [description]
     */
    public function viewMethod($projectSlug, $versionSlug, $all, $methodName)
    {
        $version = $this->version($projectSlug, $versionSlug);
        $object = $version->objectWithPath($all);
        $method = $object->methodWithSlug($methodName);

        // TODO: Remove need for "class"
        return view($version->viewMethod($method))
            ->with('documenter', $this->documenter())
            ->with('projects', $this->documenter()->projects)
            ->with('project', $version->project)
            ->with('version', $version)
            ->with('object', $object)
            ->with('class', $object)
            ->with('symbols', $object->symbolsCategorized())
            ->with('symbol', $method);
    }

    /**
     * Prepare to view a property wtihin a class or trait.
     *
     * /{project-slug}/{project-version}
     * /{namespace-slug}/{object-slug}/properties/{property-slug}
     *
     * @param  [type] $projectSlug  [description]
     * @param  [type] $versionSlug  [description]
     * @param  [type] $all          [description]
     * @param  [type] $propertyName [description]
     * @return [type]               [description]
     */
    public function viewProperty($projectSlug, $versionSlug, $all, $propertyName)
    {
        $version = $this->version($projectSlug, $versionSlug);
        $object = $version->objectWithPath($all);
        $property = $object->propertyWithSlug($propertyName);

        // TODO: Remove need for "class"
        return view($version->viewProperty($property))
            ->with('documenter', $this->documenter())
            ->with('projects', $this->documenter()->projects)
            ->with('project', $version->project)
            ->with('version', $version)
            ->with('object', $object)
            ->with('class', $object)
            ->with('symbols', $object->symbolsCategorized())
            ->with('symbol', $property);
    }

    private function documenter()
    {
        $dirPath = config('documenter-laravel.projects_root');
        $projectsArray = config('documenter-laravel.projects');
        $documenter = new Documenter($dirPath, $projectsArray);
        return $documenter;
    }

    private function project($slug)
    {
        $project = $this->documenter()->projectWithSlug($slug);
        return new Project($project->documenter, $slug, $project->title, $project->category);
    }

    private function version($slug, $versionSlug)
    {
        $project = $this->project($slug);
        return new Version($project, $versionSlug);
    }

    /**
     * Prepare to view a specific project.
     *
     * /{project-slug}
     * @param  [type] $projectSlug [description]
     * @return [type]              [description]
     */
    public function viewProjectOverview($projectSlug)
    {
        if ($result = $this->project($projectSlug)->viewForProjectOverview()) {
            if ($result->redirect) {
                return redirect($result->name);
            }
            return view($result->name);
        }
    }
}
