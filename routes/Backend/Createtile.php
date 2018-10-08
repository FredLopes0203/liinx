<?php

Route::group([
    'namespace'  => 'Tile',
], function () {
    Route::group([
        'middleware' => ['access.routeNeedsRole:2', 'access.routeNeedsOrganization'],
    ], function () {
        Route::get('createtile', 'TileController@create')->name('createtile');
    });
});
