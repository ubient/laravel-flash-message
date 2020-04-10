# Upgrading

Because tracking all significant changes between updates can be quite difficult, we've prepared this upgrade guide for you. Please keep in mind there might be edge cases this guide does not cover. We accept PRs to improve this guide.

## 1.x -> 2.x
The mechanism for flashing messages was adjusted to persist across redirects ([#8](https://github.com/ubient/laravel-flash-message/issues/8)).  As a result, one line was added to the `alert.blade.php` file.
If you didn't publish/customize the template (as described [here in the README](README.md#customizing-the-template)) and use the template shipping with this package, you can safely update to 2.x without any issues.

If you did however publish the template, it will now be slightly out-of-date.
To update it and make it compatible with 2.x, all you need to do is add one line to your `alert.blade.php` file:
```php
@if (session('flash_message') || session('status'))
    ...
    // Add the following line..
    @php(session()->forget('flash_message'));
@endif
```


## 2.x -> 4.x
The color utilities provided by TailwindCSS [have changed since it's 1.0 release](https://tailwindcss.com/docs/upgrading-to-v1#1-update-any-usage-of-text-bg-border-color-classes), and [we've changed our alert template to reflect this](https://github.com/ubient/laravel-flash-message/commit/58b470b8933cd5be7914620fa1b22b2411a38e4b#diff-efa7508de9508f985738c4dbb5b6147b). If you're depending on the built-in alert template this package ships with, and you're still using the older version of TailwindCSS, you'll most likely want to [publish it](README.md#customizing-the-template) prior to upgrading this newer version. To do this, you may use the following command:

```bash
php artisan vendor:publish --provider="Ubient\FlashMessage\FlashMessageServiceProvider"
```
