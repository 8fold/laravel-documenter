<?php

namespace Eightfold\Documenter\Php;

use phpDocumentor\Reflection\DocBlock as PhpDocumentorDocBlock;

use PhpParser\Node\Stmt;
use phpDocumentor\Reflection\DocBlock\Context;

class DocBlock extends PhpDocumentorDocBlock
{
    private $object = null;

    /**
     * [__construct description]
     *
     * @param $object The object type that can have a
     *                                         doc-block
     * @param PhpParser\Node\Stmt $docblock [description]
     * @param phpDocumentor\Reflection\DocBlock\Context|null $context  [description]
     */
    public function __construct($object, Stmt $docblock, Context $context = null)
    {
        $location = null;
        if (!is_null($object->getDocBlock())) {
            $location = $object->getDocBlock()->getLocation();
        }
        parent::__construct($docblock, $context, $location);
        $this->object = $object;
    }
}
