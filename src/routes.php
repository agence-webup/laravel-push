<?php

Route::group(["middleware" => 'auth.checkJWT'], function () {
    Route::post('/device/register', 'Webup\LaravelPush\DeviceController@register');
});