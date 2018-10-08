<?php

Route::group([
    'namespace'  => 'Tile',
], function () {
    Route::group([
        'middleware' => ['access.routeNeedsRole:2', 'access.routeNeedsOrganization'],
    ], function () {
        Route::resource('tile', 'TileController');
    });
});
