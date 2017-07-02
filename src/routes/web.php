<?php

$controller = Eightfold\Documenter\Controllers\ProjectsController::class;

Route::domain('developer.'.config('documenter-laravel.documenter_domain'))->group(function () use ($controller) {
    Route::get('/', $controller.'@index');
    Route::get('/{project}', $controller.'@viewProjectOverview');
    Route::get('/{project}/{version}', $controller.'@viewProjectVersion');
    Route::get('/{project}/{version}/{something}/methods/{method}', $controller.'@viewMethod')->where('something', '.*');
    Route::get('/{project}/{version}/{something}/properties/{method}', $controller.'@viewProperty')->where('something', '.*');
    Route::get('/{project}/{version}/{something}', $controller.'@viewObject')
        ->where('something', '.*');
});
