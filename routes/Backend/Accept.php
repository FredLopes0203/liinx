<?php

Route::group([
    'namespace'  => 'Accept',
], function () {
    Route::group([
        'middleware' => ['access.routeNeedsRole:2', 'access.routeNeedsOrganization'],
    ], function () {
        Route::get('accept', 'AcceptController@index')->name('acceptrequest');
    });
});
