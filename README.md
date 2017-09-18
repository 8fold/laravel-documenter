# Documenter for Laravel 5.4+ by 8fold

Documenter for Laravel is an extension and wrapper for [Documenter for PHP](https://github.com/8fold/documenter-php) to dynamically generate documentation sites using Laravel 5.4+. It is possible to use Documenter for Laravel as just a means to read project PHP files; however, if this is your goal, Documenter for PHP or [phpDocumentor](https://www.phpdoc.org) might be more in keeping with what you are looking for.

## Acquire (Composer)

```bash
composer require 8fold/documenter-laravel
```

Or add the following to your `composer.json` under `required`:

```bash
composer require "8fold/documenter-laravel": "*"
```

And add the following to your PSR-4 section of your `composer.json` (note: the first bit, I believe can be of your choosing):

```bash
"Eightfold\\DocumenterLaravel\\": "vendor/8fold/documenter-laravel/src/",
```

Recommend running composer update, even if you did `$ composer require`.

```bash
$ composer update
```

Also recommend explicitly running NPM:

```bash
$ npm update
```

Then publish vendor assets:

```bash
$ php artisan vendor:publish
```

Now you're ready to set everything up.

## Getting up and running

When it comes to setup, Documenter leans more toward convention over configuration. So, putting files into folders, over having to manipulate the configuration file a lot.

Register the service provider in your `/config/app.php` file under `providers`:

```bash
Eightfold\DocumenterLaravel\DocumenterServiceProvider::class
```

Note: The vendor and package name is set within your `composer.json`.

**Routes:** Documenter does not attempt to be the main purpose for your Laravel project. Therefore, the default routes used, incorporate a subdomain named `developer`. However, you should be able to override this by copying the routes within the group and still use the default `ProjectsController.php`.

**Documenter main:** Create a folder somewhere within your project where you will put the files you want to generate APIs for. The default is `/base-laravel-app/app_docs`. You can change this in the `/config/documenter-laravel.php`.

**Project folder:** Create a folder for each project you want Documenter to process under the previous directory. This folder will hold all the versions. The name of the folder should be in slug form. ex. `documenter-laravel`.

**Version folder:** Create a folder within the project folder that represents a version. The version name should be in slug form. ex. `v1-0-0`. The is the folder level in which you will place the code you want to process. By default, Documenter limits its processing to a directory called `src` at this level.

**Sass:** If you are using the default look and feel and related templates, `@import` the related Sass file:

```sass
@import 'vendor/8fold/documenter/documenter';
```

At this point, you should be almost good to go. If this seems incomplete (may be missing JavaScript), please correct or [submit an issue](https://github.com/8fold/documenter-php/issues). Thank you!

## Configuration

**documenter_domain:** The domain name to use. Recommend making this a variable in `.env`. `DOCUMENTER_DOMAIN` is the default variable name being used.

**projects_root:** Default is `app_docs` at the base of your Laravel project. This puts that folder directly under you main `app` directory in Laravel.

**projects:** This is the big one, but hopefully it is simple. Documenter will limit itself to only projects listed here. The dictionary key should match the slug for the project you chose in setting things up. The value is a dictionary with "title" and "category" keys, where the value of "title" is the human-friendly string of the project and "category" is the human-friendly string to categorize the projects. The "category" key is optional (I think). So, an example, let's use Documenter for Laravel 5.4+.

```php
'project' => [
    'documenter-php' => [
        'title' => 'Documenter for Laravel 5.4+',
        'category' => 'Documentation generators'
    ]
]
```

This would mean Documenter expects the following (using the default setup):

```bash
/app_docs
    /documenter-php
        /v1-0-0
        /...
```

## Views

If you have done the previous steps, at this point, you should be able to generate a site. However, it may not match the look and feel you would prefer. Documenter tries to make it easy (or at least easier). You use all the Laravel things you are accustomed to; not a lot of new things to learn here.

Again, we try to use convention over configuration.

When you run `$ php artisan vendor:publish`, a "documenter" folder is generated in the main `/resources/views`. Initially it is an empty directory and you can (should be able to) put files and folders into this directory to tell Documenter what views to use and when. Let's start with the most customized view.

```bash
/resources/views/documenter
  /documenter-php
    /v1-0-0
      home.blade.php
      method.blade.php
      object.blade.php
      property.blade.php
    projectOverview.blade.php
  documenterIndex.blade.php
```

- **documenterIndex:** Documenter assumes this template is used to list all the projects and allow users to navigate to one of them.
- **projectOverview:** Documenter assumes this template is used to list all the versions available for the project, with optional description and other assets.
- **home:** Documenter assumes this template is used to list all the classes, traits, and interfaces within the project version, with optional description and other assets.
- **object:** Documenter assumes this template is listing the properties and methods for a class, trait, and interface.
- **method and property:** Documenter assumes these templates display the documentation for a method or property within the project.

This setup allows you to create a layout specific to a project version. It is also possible to create a generic set of templates for all projects regardless of version.

```bash
/resources/views/documenter
  /version
    home.blade.php
    method.blade.php
    object.blade.php
    property.blade.php
  projectOverview.blade.php
  documenterIndex.blade.php
```

Now, any project being considered by Documenter will use these templates. The assumed purpose of each does not change. Note: This is the out of the box setup for Documenter.

If you do not use a `projectOverview` template, Documenter will attempt to redirect users to the home page of the highest version of the project (by default, Documenter does *not* include a `projectOverview` template).

To recap, Documenter will first look for a template file under the project and version. If it does not find one, it will look for a template within your `/resources/views/documenter` and `/resources/views/documenter/version` directories. If it does not find one, it will use its own templates.

If this seems incomplete or not what you experience, please correct or [submit an issue](https://github.com/8fold/documenter-php/issues). Thank you!
