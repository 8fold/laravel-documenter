<?php

namespace Eightfold\DocumenterLaravel\Php;

use Illuminate\Support\Facades\View;

use Eightfold\DocumenterPhp\Documenter as phpDocumenter;

class Documenter extends phpDocumenter
{
    /**
     * Display Documenter welcome page.
     *
     * This represents the root for your documenter installation and allows you to
     * create a route under your domain.
     *
     * ex. https://example.com/ - default
     *     https://example.com/documentation/ - override
     *
     * @return [type] [description]
     */
    public function viewForIndex()
    {
        if (View::exists('documenter.index')) {
            // Use documenter folder within main views.
            return 'documenter.index';

        } elseif (View::exists('documenterIndex')) {
            // Use standard Laravel.
            return 'documenterIndex';

        }
        // Use Documenter default welcome.
        return 'documenter::documenterIndex';
    }
}
