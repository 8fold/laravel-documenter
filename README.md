# Documenter for Laravel 5.4+ by 8fold

*Note: Initially, Documenter was not designed to be a standalone service. Therefore, at present integration is somewhat esoteric, because it is still based on the original project in which it was used. We are working to create its future in a way that allows it to create a site out of the box, while offering you the flexibility to easily build your own templates, routes, and sites.*

Documenter dynamically generates a documentation site for PHP projects. Documenter is built on top of [phpDocumentor](https://www.phpdoc.org), one of the most well known and used documentation generators for PHP projects.

## Setup

Add this to `providers` in your `/config/app.php` file:

```
GrahamCampbell\Markdown\MarkdownServiceProvider::class
```

## Grouping things together

You can group classes, traits, interfaces, methods, and properties when they are returned from a project. The way you do this is by adding a `@category` tag to the DocBlock of the desired object. 

*Note: This is* not *the category tag described in the [phpDocumentor documentation](https://www.phpdoc.org/docs/latest/references/phpdoc/tags/category.html); instead, it is just the semantically appropriate name for what we are trying to accomplish. Therefore, to define hierarchical relationships, follow the instructions in the documentation.* 

## Override views

Laravel allows you to override the views provided by the package by following instructions found in the [Laravel documentation](https://laravel.com/docs/5.4/packages#views).
