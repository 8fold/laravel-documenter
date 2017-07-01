<?php

$controller = Eightfold\Documenter\Controllers\ProjectsController::class;

// Route::get('/', function () {
//     return view('documenter::welcome');
// });

Route::domain('developer.'.env('APP_DOMAIN'))->group(function () use ($controller) {
    Route::get('/', $controller.'@index');
    Route::get('/{project}', $controller.'@viewProjectOverview');
    Route::get('/{project}/{version}', $controller.'@viewProjectVersion');





    // Route::get('/{project}/{version}/traits/{trait}', $controller.'@viewTrait');
    // Route::get('/{project}/{version}/interfaces/{trait}', $controller.'@viewInterface');
    Route::get('/{project}/{version}/{something}/methods/{method}', $controller.'@viewMethod')->where('something', '.*');
    Route::get('/{project}/{version}/{something}/properties/{method}', $controller.'@viewProperty')->where('something', '.*');
    Route::get('/{project}/{version}/{something}', $controller.'@viewSomething')
        ->where('something', '.*');
});

// Route::group([
//         'prefix' => 'documentation.'.env(APP_DOMAIN)
//     ], function() use ($controller) {
//     Route::get('/', $controller.'@index');
//     Route::get('/{project}', $controller.'@viewProjectOverview');
//     Route::get('/{project}/{version}', $controller.'@viewProjectVersion');
//     Route::get('/{project}/{version}/traits/{trait}', $controller.'@viewTrait');
//     Route::get('/{project}/{version}/interfaces/{trait}', $controller.'@viewInterface');
//     Route::get('/{project}/{version}/{something}/methods/{method}', $controller.'@viewMethod')->where('something', '.*');
//     Route::get('/{project}/{version}/{something}/properties/{method}', $controller.'@viewProperty')->where('something', '.*');
//     Route::get('/{project}/{version}/{something}', $controller.'@viewSomething')
//         ->where('something', '.*');
// });

