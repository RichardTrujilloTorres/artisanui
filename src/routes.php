<?php

Route::prefix(config('artisanui.api.prefix').'/'.config('artisanui.api.version'))->group(function () {
    Route::namespace('Desemax\\ArtisanUI\\Http\\Controllers\\API')->group(function () {
        Route::get('commands', 'CommandsController@index');
        Route::post('commands/run', 'CommandsController@run');
    });
});

