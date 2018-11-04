# Upgrading

Because there are many breaking changes an upgrade is not that easy. There are many edge cases this guide does not cover. We accept PRs to improve this guide.

## 1.x -> 2.x
The mechanism for flashing messages was adjusted to persist across redirects ([#8](https://github.com/ubient/laravel-flash-message/issues/8)).  As a result, one line was added to the `alert.blade.php` file.
If you didn't publish/customize the template (as described [here in the README](README.md#customizing-the-template)) and use the template shipping with this package, you can safely update to 2.x without any issues.

If you did however publish the template, it will now be slightly out-of-date.
To update it and make it compatible with 2.x, all you need to do is [add one line to your `alert.blade.php` file](https://github.com/ubient/laravel-flash-message/commit/0e25c47b889eb168146773912f7e7577a989e838#diff-efa7508de9508f985738c4dbb5b6147b).
```php
@if (session('flash_message') || session('status'))
    ...
    // Add the following line..
    @php(session()->forget('flash_message'));
@endif
```
