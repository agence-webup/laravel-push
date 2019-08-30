# Laravel Push

This package serves as a bridge between a Laravel application and a [webup/push](https://github.com/matthmart/push) instance.


## Installation 

### Require package with composer

```
$ composer require webup/laravel-push
```

### Configure base URI in the environment

Set the `PUSH_API_BASE_URI` environment variable to the URI for _webup/push_.

Please note _webup/push_ listens on port `3000` by default.

### Configure service in config/services.php

```php
'push_api' => [
        'base_uri' => env('PUSH_API_BASE_URI'),
    ]
```

---

## How to use the Token Jobs

### AssignToken

`Webup\LaravelPush\Jobs\Token\AssignToken` can be called directly from a controller or pretty much any class you need it in.
To do so you must import the job in your class with the following `use` statement:

```php
use Webup\LaravelPush\Jobs\Token\AssignToken;
```

You can then perform a `dispatch_now()`, while specifying an `id`, which is meant to identify which user/device/whatever the Token is linked to, as well as an `array` containing:

- the `token` (the device's FCM push token)
- the `platform` (iOS or Android, respectively 1 and 2) 
- the device's `language` code.

For example: 

```php
dispatch_now(new AssignToken(
    auth()->user()->id, // In this case, user to whom the token is assigned
    [
        'token' => $push_token,     // The device's FCM push token
        'platform' => $device_type, // iOS (1) or Android (2)
        'language' => 'fr',         // The device's language code
    ]
));
```

### RemoveToken

`Webup\LaravelPush\Jobs\Token\RemoveToken` works exactly the same as _AssignToken_, but serves the purpose of removing the token from your database.