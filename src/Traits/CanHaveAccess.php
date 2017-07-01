<?php

namespace Eightfold\DocumentorLaravel\Traits;

trait CanHaveAccess
{
    /**
     * @todo Change symbol order [category][property/function][access]
     * @param  [type] $highlight [description]
     * @param  [type] &$build    [description]
     * @return [type]            [description]
     */
    private function getAccessKeyword($highlight, &$build)
    {
        if ($this->isPublic() || $this->isProtected() || $this->isPrivate()) {
            $build[] = $this->getHighlightedString($this->access(), 'access');

        }
    }

    protected function access()
    {
        return $this->reflector->getVisibility();
    }

    /**
     * Whether the method is publicly accessible or not.
     *
     * @return boolean [description]
     *
     * @category Check method details
     */
    public function isPublic()
    {
        return $this->isAccessLevel();
    }

    /**
     * Whether the method is accessible to subclasses.
     *
     * @return boolean [description]
     *
     * @category Check method details
     */
    public function isProtected()
    {
        return $this->isAccessLevel('protected');
    }

    /**
     * Whether the method is accessible only to the declaring class.
     *
     * @return boolean [description]
     *
     * @category Check method details
     */
    public function isPrivate()
    {
        return $this->isAccessLevel('private');
    }

    /**
     * Whether the method has the given access value.
     *
     * @param  string  $accessLevel public|protected|private
     * @return boolean              [description]
     *
     * @category Check method details
     */
    private function isAccessLevel($accessLevel = 'public')
    {
                // dd($this->node);
        return ($this->reflector->getVisibility() == $accessLevel);
    }
}
