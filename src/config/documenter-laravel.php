<?php

return [

    /**
     * If using Documenter as a subdomain (default),
     * this is the domain to use with routes.
     *
     * ex:
     * example.com becomes
     * developer.example.com
     *
     * You can create the variable in your .env file (recommended)
     *
     */
    'documenter_domain' => env('DOCUMENTER_DOMAIN'),

    /**
     * The path to the directory containing the projects you want
     * Documenter to index and use.
     *
     * ex:
     * /app_docs
     *     /project-1
     *         /v1-0-0
     *         /v1-5-0
     *     /project-2
     *         /v0-0-1
     *
     */
    'projects_root' => base_path() .'/app_docs',

    /**
     * A dictionary where the key is the directory name within projects_root and
     * the value is the title to display for the project.
     *
     * ex.
     *
     * [
     *     'documenter-php' => [
     *         'title' => 'Documenter PHP',
     *         'category' => 'API Documentation Generators'
     *     ]
     * ]
     *
     */
    'projects' => []
];
