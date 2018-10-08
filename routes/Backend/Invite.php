<?php

Route::group([
    'namespace'  => 'Invite',
], function () {
    Route::group([
        'middleware' => ['access.routeNeedsRole:2', 'access.routeNeedsOrganization'],
    ], function () {
        Route::get('invite', 'InviteController@index')->name('inviteuser');
        Route::post('gettileuser', 'InviteController@getTileUsers')->name('invite.gettileuser');
    });
});
