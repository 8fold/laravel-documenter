# Documenter for Laravel 5.4+ by 8fold

*Note: Initially, Documenter was not designed to be a standalone service. Therefore, at present integration is somewhat esoteric, because it is still based on the original project in which it was used. We are working to create its future in a way that allows it to create a site out of the box, while offering you the flexibility to easily build your own templates, routes, and sites.*

Documenter dynamically generates a documentation site for PHP projects. Documenter is built on top of [phpDocumentor](https://www.phpdoc.org), one of the most well known and used documentation generators for PHP projects.

## Setup

Add this to `aliases` in your `/config/app.php` file:

```
'DocumenterMarkdown' => GrahamCampbell\Markdown\Facades\Markdown::class
```

## Config

```
php artisan vendor:publish --provider="Eightfold\Documenter\DocumenterServiceProvider"
```



## Override views

Laravel allows you to override the views provided by the package by following instructions found in the [Laravel documentation](https://laravel.com/docs/5.4/packages#views).
