<?php

namespace Eightfold\Documenter\Traits;

use Eightfold\Documenter\Php\Parameter;

use phpDocumentor\Reflection\DocBlock\Tag\ParamTag;
use phpDocumentor\Reflection\DocBlock\Tag\PropertyTag;
use phpDocumentor\Reflection\DocBlock\Tag\VarTag;
use phpDocumentor\Reflection\DocBlock\Tag\ReturnTag;

/**
 * @todo Consider creating a class for this.
 */
trait DocBlockable
{
    private $docBlock = null;

    private $deprecatedDescription = '';

    /**
     * @deprecated
     * @return [type] [description]
     */
    public function description()
    {
        return $this->shortDescription();
    }

    public function category()
    {
        if (!is_null($this->docBlock()) && $this->docBlock()->hasTag('category')) {
            $category = $this->docBlock()->getTagsByName('category');
            // always use the first one.
            $category = $category[0];

            // always use the short description for categories.
            return $category->getDocBlock()->getShortDescription();
        }
        return null;
    }

    public function getText()
    {
        if (!is_null($this->docBlock)) {
            return $this->docBlock->getText();
        }
        return '';
    }

    public function shortDescription()
    {
        if (!is_null($this->docBlock())) {
            return $this->docBlock()->getShortDescription();
        }
        return '';
    }

    // public function longDescription()
    // {
    //     if (!is_null($this->docBlock()) && strlen($this->docBlock()->getLongDescription()) > 0) {
    //         return $this->docBlock()->getLongDescription();
    //     }
    //     return $this->shortDescription();
    // }

    public function docBlock()
    {
        if (is_null($this->docBlock)) {
            if (is_a($this, Parameter::class)) {

                $this->docBlock = $this->method->docBlock();

            } else {
                $this->docBlock = $this->reflector->getDocBlock();

            }
        }
        return $this->docBlock;
    }

    public function typeHint($withLink = false)
    {
        $project = $this->project;

        $name = $this->reflector->getShortName();
        $tags = (is_null($this->docBlock()))
            ? []
            : $this->docBlock()->getTags();

        $tag = null;
        foreach ($tags as $tag) {
            if ((get_class($tag) == PropertyTag::class) || (get_class($tag) == ParamTag::class) || (get_class($tag) == VarTag::class)) {
                if ($tag->getVariableName() == '$'. $name) {
                    $tag = $tag;
                    break;
                }

            // } elseif (get_class($tag) == ReturnTag::class) {
            //     $tag = $this->returnTagString($withLink);

            } else {
                $tag = $tag;

            }
        }

        $return = [];
        if (!is_null($tag)) {
            $type = $tag->getType();
            $longName = ltrim($type, '\\');
            if ($project->hasClass(ltrim($type, '\\'))) {
                $class = $project->objectWithLongName($type);
                $build = [];
                $build['url'] = $class->url();
                $build['name'] = $class->name();
                $return[] = (object) $build;

            } else {
                $build = [];
                $build['url'] = null;
                $build['name'] = str_replace('\\\\', '', str_replace($this->getNamespace(), '', $type));
                $return[] = (object) $build;

            }
        }
        return $return;
    }

    /**
     * @todo Deprecate and consolidate all typeHint functionality.
     *
     * @param  string  $tagName  [description]
     * @param  boolean $withLink [description]
     *
     * @return [type]            [description]
     *
     * @deprecated
     */
    private function typeString($tagName = 'param', $withLink = false)
    {
        $typesChecked = [];
        if (!is_null($this->docBlock)) {
            $tags = $this->docBlock->getTagsByName($tagName);
            foreach ($tags as $tag) {
                $types = $tag->getTypes();
                foreach ($types as $type) {
                    if ($this->project->hasClass($type)) {
                        $class = $this->project->objectWithLongName($type);
                        $typesChecked[] = trim($class->name($withLink));

                    } else {
                        $namespace = $this->context->getNamespace();
                        $typesChecked[] = str_replace([$namespace, '\\'], ['', ''], $type);

                    }
                }
            }
            return implode('|', $typesChecked);
        }
    }

    /**
     * @todo Make CanBeDeprecated trait
     *
     * @return boolean [description]
     */
    public function isDeprecated()
    {
        if (!is_null($this->docBlock()) && $this->docBlock()->hasTag('deprecated')) {
            $this->setDeprecatedDescription();
            return true;
        }
        return false;
    }

    private function setDeprecatedDescription()
    {
        $docTag = $this->docBlock()->getTagsByName('deprecated');
        $docTag = $docTag[0];
        $this->deprecatedDescription = $docTag->getDocBlock()->getShortDescription();
    }

    public function deprecatedDescription()
    {
        if (strlen($this->deprecatedDescription) == 0 && $this->isDeprecated()) {
            $this->setDeprecatedDescription();
        }
        return $this->deprecatedDescription;
    }
}
