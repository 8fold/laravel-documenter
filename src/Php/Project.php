<?php

namespace Eightfold\Documenter\Php;

use Eightfold\DocumenterPhp\Project as phpProject;
// use \DirectoryIterator;
// use \RecursiveDirectoryIterator;
// use \RecursiveCallbackFilterIterator;
// use \FilesystemIterator;

// use Eightfold\Documenter\Php\File;
// use Eightfold\Documenter\Php\Class_;
// use Eightfold\Documenter\Php\Trait_;
// use Eightfold\Documenter\Php\Interface_;
// use Eightfold\Documenter\Php\Method;
// use Eightfold\Documenter\Php\Property;

class Project extends phpProject
{
    // private $url = '';

    // private $slug = '';

    // private $versionSlug = '';

    // private $projectVersionsDirectory = '';

    // private $versions = [];

    // private $files = [];

    // private $classes = [];

    // private $classesOrdered = [];

    // private $traits = [];

    // private $traitsOrdered = [];

    // private $interfaces = [];

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

    // static private function getIteratorForPath($path, $ignore)
    // {
    //     $directory = new RecursiveDirectoryIterator(
    //         $path,
    //         FilesystemIterator::FOLLOW_SYMLINKS
    //     );

    //     $filter = new RecursiveCallbackFilterIterator(
    //         $directory,
    //         function ($current, $key, $iterator) use ($ignore) {
    //             if ($current->getFilename()[0] === '.') {
    //                 // Skip hidden files and directories.
    //                 return false;

    //             } elseif ($current->isDir()) {
    //                 $filePath = strtolower($current->getFilename());
    //                 $filePathExploded = explode('/', $filePath);
    //                 $intersect = array_intersect($filePathExploded, $ignore);
    //                 $remainingCount = count($intersect);
    //                 return (0 == $remainingCount);

    //             } else {
    //                 // TODO: Be able to ignore and keep specific files.
    //                 return str_replace(base_path(), '', $current->getFilename());

    //             }
    //     });
    //     $iterator = new \RecursiveIteratorIterator($filter);
    //     return $iterator;
    // }

    // public function __construct($slug, $rootDir = '/src', $ignoreDirs = ['views', 'routes', 'theme-json'])
    // {
    //     $slugExploded = explode('/', $slug);
    //     if (count($slugExploded) < 3) {
    //         dd('Invalid files path presented.');

    //     }

    //     $this->slug = $slugExploded[1];
    //     $this->versionSlug = $slugExploded[2];
    //     $this->url = '/'. $this->slug .'/'. $this->versionSlug;

    //     $documenterDocs = config('documenter-laravel.projects_root');

    //     $this->projectVersionsDirectory = $documenterDocs . $slug;
    //     $iterator = static::getIteratorForPath($this->projectVersionsDirectory . $rootDir, $ignoreDirs);
    //     $files = [];
    //     foreach ($iterator as $info) {
    //         $file = new File($info->getPathname());
    //         $key = str_slug($file->getNamespace());
    //         $files[$key][] = $file;
    //     }
    //     $this->files = $files;
    // }

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














    // public function hasLongName($longName)
    // {
    //     $longSlug = str_slug($longName);
    //     if (isset($this->files[$longSlug])) {
    //         return true;
    //     }
    //     return false;
    // }

    // public function hasClass($classLongName)
    // {
    //     if (strlen($classLongName) > 0 && $class = $this->objectWithLongName($classLongName)) {
    //         return (is_a($class, 'Eightfold\Documenter\Php\Class_'));
    //     }
    //     return false;
    // }

    // public function url()
    // {
    //     return $this->url;
    // }

    // public function urlForVersion($version = null)
    // {
    //     if (is_null($version)) {
    //         return $this->url() .'/'. str_replace('.', '-', $version);
    //     }
    //     return $this->url();
    // }

    // public function slug()
    // {
    //     return $this->slug;
    // }

    // public function version()
    // {
    //     return $this->versionSlug;
    //     if (count($this->versions) == 0) {
    //         $path = explode('/', $this->projectVersionsDirectory);
    //         array_pop($path);
    //         $path = implode('/', $path);
    //         $iterator = new DirectoryIterator($path);
    //         foreach ($iterator as $content) {
    //             if($content->isDir() && !$content->isDot()) {
    //                 $this->versions[] = $content->getFilename();
    //                 usort($this->versions, 'version_compare');
    //                 $this->versions = array_reverse($this->versions);
    //             }
    //         }
    //     }
    //     return $this->versions;
    // }

    // public function space()
    // {
    //     $spaceBuild = $this->interfaces();
    //     if (count($spaceBuild) == 0) {
    //         $spaceBuild = $this->traits();

    //     }
    //     foreach ($spaceBuild as $space) {
    //         $namespace = $space->longName();
    //         $exploded = explode('\\', $namespace);
    //         return $exploded[0] .'\\'. $exploded[1];
    //     }
    //     dd(__CLASS__ .':'. __LINE__ .':check traits, then classes');
    // }

    /**
     * @category Retrieve objects
     *
     * @param  [type] $path [description]
     * @return [type]       [description]
     */
    // private function longNameFromPath($path)
    // {
    //     $pathParts = explode('/', $path);
    //     $parts = [];
    //     foreach ($pathParts as $part) {
    //         $parts[] = studly_case($part);
    //     }
    //     return $this->space() .'\\'. implode('\\', $parts);
    // }

    /**
     * @category Retrieve objects
     *
     * @param  [type] $path [description]
     * @return [type]       [description]
     */
    // public function objectWithPath($path)
    // {
    //     $longName = $this->longNameFromPath($path);
    //     return $this->objectWithLongName($longName);
    // }

    // /**
    //  * @category Retrieve objects
    //  *
    //  * @param  [type] $longName [description]
    //  * @return [type]           [description]
    //  */
    // public function objectWithLongName($longName)
    // {
    //     $longNameToKey = str_slug($longName);

    //     $classes = $this->classes();
    //     if (isset($classes[$longNameToKey])) {
    //         return $classes[$longNameToKey];

    //     }

    //     $traits = $this->traits();
    //     if (isset($traits[$longNameToKey])) {
    //         return $traits[$longNameToKey];

    //     }

    //     $interfaces = $this->interfaces();
    //     if (isset($interfaces[$longNameToKey])) {
    //         return $interfaces[$longNameToKey];

    //     }
    //     return null;
    // }

    /**
     * @category Retrieve objects
     *
     * @return [type] [description]
     */
    // public function classesOrdered()
    // {
    //     $propertyName = 'classesOrdered';
    //     if (count($this->{$propertyName}) == 0) {
    //         $symbols = $this->classes();
    //         $abstract = 0;
    //         $build = [];
    //         foreach ($symbols as $key => $symbol) {
    //             $category = (strlen($symbol->category()) > 0)
    //                 ? $symbol->category()
    //                 : 'NO_CATEGORY';
    //             $type = 'concrete';
    //             if ($symbol->isAbstract()) {
    //                 $type = 'abstract';
    //                 $abstract++;
    //             }
    //             $build[$category][$type][$symbol->name()] = $symbol;

    //         }

    //         if ($abstract == 0) {
    //             $this->{$propertyName} = [];

    //         } else {
    //             foreach ($build as $category => $types) {
    //                 foreach ($types as $type => $symbols) {
    //                     ksort($symbols);
    //                     $build[$category][$type] = $symbols;
    //                 }
    //             }
    //             $this->{$propertyName} = $build;
    //         }
    //     }
    //     return $this->{$propertyName};
    // }

    /**
     * @category Retrieve objects
     *
     * @return [type] [description]
     */
    // public function traitsOrdered()
    // {
    //     $propertyName = 'traitsOrdered';
    //     if (count($this->{$propertyName}) == 0) {
    //         $symbols = $this->traits();
    //         $abstract = 0;
    //         $build = [];
    //         foreach ($symbols as $key => $symbol) {
    //             $category = (strlen($symbol->category()) > 0)
    //                 ? $symbol->category()
    //                 : 'NO_CATEGORY';
    //             $type = 'NO_TYPE';
    //             if (get_class($symbol) == Class_::class || get_class($symbol)  == Method_::class) {
    //                 if ($symbol->isAbstract()) {
    //                     $type = 'abstract';
    //                     $abstract++;

    //                 } else {
    //                     $type = 'concrete';

    //                 }
    //             }
    //             $build[$category][$type][$symbol->name()] = $symbol;

    //         }

    //         if ($abstract == 0) {
    //             $this->{$propertyName} = $build;

    //         } else {
    //             foreach ($build as $category => $types) {
    //                 foreach ($types as $type => $symbols) {
    //                     ksort($symbols);
    //                     $build[$category][$type] = $symbols;
    //                 }
    //             }
    //             $this->{$propertyName} = $build;
    //         }
    //     }
    //     return $this->{$propertyName};
    // }

    // /**
    //  * @category Files
    //  *
    //  * @return [type] [description]
    //  */
    // public function classes()
    // {
    //     return $this->filesForPropertyName('classes', 'getClasses', Class_::class);
    // }

    // /**
    //  * @category Files
    //  *
    //  * @return [type] [description]
    //  */
    // public function traits()
    // {
    //     return $this->filesForPropertyName('traits', 'getTraits', Trait_::class);
    // }

    /**
     * @category Files
     *
     * @return [type] [description]
     */
    // public function interfaces()
    // {
    //     return $this->filesForPropertyName('interfaces', 'getInterfaces', Interface_::class);
    // }

    // /**
    //  *
    //  * @category Files
    //  *
    //  * @param  [type] $propertyName       [description]
    //  * @param  [type] $fileMethodName     [description]
    //  * @param  [type] $classToInstantiate [description]
    //  * @return [type]                     [description]
    //  */
    // private function filesForPropertyName($propertyName, $fileMethodName, $classToInstantiate)
    // {
    //     if (count($this->files) > 0 && count($this->{$propertyName}) == 0) {
    //         $objects = [];
    //         foreach ($this->files as $namespace => $namespaceFiles) {
    //             foreach ($namespaceFiles as $file) {
    //                 if (method_exists($file, $fileMethodName)) {
    //                     $reflectorsAfterMethodCall = $file->$fileMethodName();
    //                     foreach ($reflectorsAfterMethodCall as $reflector) {
    //                         $object = new $classToInstantiate($this, $reflector);
    //                         $key = str_slug($object->longName());
    //                         $objects[$key] = $object;

    //                     }
    //                 }
    //             }
    //         }
    //         $this->{$propertyName} = $objects;
    //     }
    //     return $this->{$propertyName};
    // }
}
