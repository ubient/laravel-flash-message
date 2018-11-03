# Laravel Flash Message

[![Latest Version](https://img.shields.io/github/release/ubient/laravel-flash-message.svg?style=flat-square)](https://github.com/ubient/laravel-flash-message/releases)
[![Build Status](https://img.shields.io/travis/ubient/laravel-flash-message/master.svg?style=flat-square)](https://travis-ci.org/ubient/laravel-flash-message)
[![Quality Score](https://img.shields.io/scrutinizer/g/ubient/laravel-flash-message.svg?style=flat-square)](https://scrutinizer-ci.com/g/ubient/laravel-flash-message)
[![StyleCI](https://styleci.io/repos/154986115/shield)](https://styleci.io/repos/154986115)
[![Total Downloads](https://img.shields.io/packagist/dt/ubient/laravel-flash-message.svg?style=flat-square)](https://packagist.org/packages/ubient/laravel-flash-message)

This package provides a Laravel Flash Message that can be used to display an one-time status message to your users.

## Usage

When redirecting, you can fluently chain one of the [available methods](#available-methods), similar to how you would [flash other session data](https://laravel.com/docs/5.7/redirects#redirecting-with-flashed-session-data):

```php
return redirect()
    ->route('login')
    ->withErrorMessage('To execute this action, you need to be logged in first.');
```

With the message flashed to the session, all that remains is to display it to your users.
A good place to start doing so, is by including the alert we've shipped with this package into your view(s):
```php
@include('flash-message::alert')
```

If you're testing your application, and would like to assert whether the flash message was set, you can do so
by calling one of the [available assertions](#available-assertions) on the TestResponse object:
```php
// @see https://laravel.com/docs/5.7/http-tests#testing-json-apis
$testResponse = $this->post('/topics/1/replies', ['message' => 'My example reply']);

// Assert that the success flash message was set, and that it contains the expected message:
$testResponse->assertHasSuccessMessage('Your reply has been added.');

// Alternatively, we can also assert that some (any) success flash message was set:
$testResponse->assertHasSuccessMessage();
```

#### Available Methods

- `withInfoMessage('Message')`: Flashes a message that indicates a neutral informative change or action.
- `withSuccessMessage('Message')`: Flashes a message that indicates a successful or positive action.
- `withWarningMessage('Message')`: Flashes a message that indicates a warning that might need attention.
- `withErrorMessage('Message')`: Flashes a message that indicates an erroneous, dangerous or negative action.

#### Available Assertions

- `assertHasInfoMessage('Message')`: Asserts that a flash message was set using `withInfoMessage`.
- `assertHasSuccessMessage('Message')`: Asserts that a flash message was set using `withSuccessMessage`
- `assertHasWarningMessage('Message')`: Asserts that a flash message was set using `withWarningMessage`
- `assertHasErrorMessage('Message')`: Asserts that a flash message was set using `withErrorMessage`

### Customizing the template
By default, our alert uses [TailwindCSS](https://github.com/tailwindcss/tailwindcss)'s utility classes to style the alert,
but odds are you're either using something else or want to modify how the alert looks altogether.
Luckily, doing so is fairly easy:

1. Publish our template into your application by running the following artisan command:
```bash
php artisan vendor:publish --provider="Ubient\FlashMessage\FlashMessageServiceProvider"
```
2. Modify the template located at `resources/views/vendor/flash-message/alert.blade.php`.
3. That's all! Laravel will automatically pick up on the changes you've made.


## Installation

You can install the package via composer:

```bash
composer require ubient/laravel-flash-message
```

The package will automatically register itself.

## Testing

You can run the test using:

``` bash
vendor/bin/phpunit
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email claudio@ubient.net instead of using the issue tracker.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
