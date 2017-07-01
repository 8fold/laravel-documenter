<?php

namespace Eightfold\Documenter\Controllers;

use App\Http\Controllers\Controller;

// use \RecursiveDirectoryIterator;
use \DirectoryIterator;

use phpDocumentor\Reflection\FileReflector;
use phpDocumentor\Reflection\Traverser;
use phpDocumentor\Reflection\DocBlock;

// use Eightfold\Documenter\Models\Project;
use Eightfold\Documenter\Php\ObjectClass;
use Eightfold\Documenter\Php\ObjectProperty;
use Eightfold\Documenter\Php\Trait_;
use Eightfold\Documenter\Php\ObjectInterface;

use Eightfold\Documenter\Php\ProjectClass;
use Eightfold\Documenter\Php\ProjectTrait;
use Eightfold\Documenter\Php\Method;

use Eightfold\Documenter\Php\Project as phpProject;

use GrahamCampbell\Markdown\Facades\Markdown;

/**
 * This should appear??
 *
 * Creating things.
 *
 * @deprecated Something something else
 */
class ProjectsController extends Controller
{
    private $projects = [];

    private $versions = [];

    public function index()
    {
        return view('documenter::overview')
            ->with('projects', $this->projects());
    }

    public function viewProjectOverview($projectSlug)
    {
        $project = new phpProject($projectSlug);
        if ($project->viewExists('overview')) {
            return $this->baseViewWith($project, $project->viewForProjectOverview());
        }
        $versions = $project->versions();
        return redirect(url($projectSlug .'/'. $versions[0]));
    }

    private function baseViewWith($project, $viewName)
    {
        return view($viewName)
            ->with('project_slug', $project->slug())
            ->with('projects', $this->projects())
            ->with('project', $project)
            ->with('project_namespace', $project->space())
            ->with('title_view', $project->viewForTitle());
    }

    private function viewWithVersion($project, $viewName, $versionSlug)
    {
        $base = $this->baseViewWith($project, $viewName);
        return $base
            ->with('version', str_replace('-', '.', $versionSlug))
            ->with('project_versions', $this->versions($project->slug()));
    }

    private function viewWithDiscussion($project, $versionSlug, $all)
    {
        $object = $project->objectWithPath($all);
        $discussion = $this->getDiscussion($object);

        return $this->viewWithVersion($project, $project->viewForObject($object), $versionSlug)
            ->with('symbols', $object->symbolsOrdered())
            ->with('discussion', $discussion);
    }

    /**
     * @todo Handle single namespace not returning an array from ApiGen.
     *
     * @param  [type] $project_slug [description]
     * @param  [type] $version_slug [description]
     * @return [type]               [description]
     */
    public function viewProjectVersion($projectSlug, $versionSlug)
    {
        $project = new phpProject('/'. $projectSlug .'/'. $versionSlug);
        $classes = $project->classesOrdered();
        $traits = $project->traits();
        $interfaces = $project->interfaces();
        return $this->viewWithVersion($project, $project->viewForHome(), $versionSlug)
            ->with('classesOrdered', $classes)
            ->with('traits', $traits)
            ->with('interfaces', $interfaces);
    }

    /**
     * TODO: Change name to viewProjetObject()
     *
     * @param  [type] $projectSlug [description]
     * @param  [type] $versionSlug [description]
     * @param  [type] $all         [description]
     * @return [type]              [description]
     */
    public function viewSomething($projectSlug, $versionSlug, $all)
    {
        $project = new phpProject('/'. $projectSlug .'/'. $versionSlug);

        // TODO: change method name to objectWithPath
        $object = $project->objectWithPath($all);

        $view = $this->viewWithDiscussion($project, $versionSlug, $all);

        switch (get_class($object)) {
            case 'Eightfold\Documenter\Php\Interface_':
                return $view->with('interface', $object);
                break;

            case 'Eightfold\Documenter\Php\Trait_':
                return $view->with('object', $object);
                break;

            default:
                return $view
                    ->with('object', $object)
                    ->with('traits', $object->traits());
                break;
        }
    }

    public function viewMethod($projectSlug, $versionSlug, $all, $method_name)
    {
        $project = new phpProject('/'. $projectSlug .'/'. $versionSlug);




        $class = $project->objectWithPath($all);
        $method = $class->methodWithSlug($method_name);
        return view($project->viewForMethod($method))
            ->with('project_slug', $projectSlug)
            ->with('version', str_replace('-', '.', $versionSlug))
            ->with('project', $project)
            ->with('projects', $this->projects())
            ->with('project_versions', $this->versions($projectSlug))
            ->with('class', $class)
            ->with('method', $method);
    }

    public function viewProperty($projectSlug, $versionSlug, $all, $propertyName)
    {
        $project = new phpProject('/'. $projectSlug .'/'. $versionSlug);
        $class = $project->classWithPath($all);
        $property = $class->propertyWithSlug($propertyName);
        return view($project->viewForProperty($property))
            ->with('project_slug', $projectSlug)
            ->with('version', str_replace('-', '.', $versionSlug))
            ->with('project', $project)
            ->with('projects', $this->projects())
            ->with('project_versions', $this->versions($projectSlug))
            ->with('class', $class)
            ->with('property', $property);
    }

    private function projects()
    {
        // dd('here');
        if (count($this->projects) == 0) {
            // dd('here');
            $projects = [];
            $directory = new DirectoryIterator(base_path() .'/app_docs');
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
            $this->projects = $projects;
        }
        return $this->projects;
    }

    private function versions($projectSlug)
    {
        $projects = $this->projects();
        if (count($this->versions) == 0 && isset($projects[$projectSlug])) {
            return $projects[$projectSlug];

        }
        return [];
    }

    // TODO: DO NOT deprecate
    private function getDiscussion($object)
    {
        $file = str_replace('\\', '-', strtolower($object->namespaceName()));
        // dd($object->project);
        $path = resource_path() .'/views/'. $object->project->slug() .'/discussions/'. $file .'.md';
        if (file_exists($path)) {
            $contents = file_get_contents($path);
            return Markdown::convertToHtml($contents);
        }
        return '';
    }
}
