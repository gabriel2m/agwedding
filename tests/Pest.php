<?php

use Illuminate\Support\Arr;
use Illuminate\Testing\TestResponse;
use Illuminate\Translation\Translator;
use Mockery\MockInterface;

use function Pest\Laravel\instance;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

uses(
    Tests\TestCase::class,
    Illuminate\Foundation\Testing\RefreshDatabase::class,
)->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function formatUrl(string|array $url)
{
    return is_array($url) ? route(...$url) : $url;
}

function mockTrans()
{
    instance(
        'translator',
        Mockery::mock(Translator::class, function (MockInterface $mock) {
            $mock->shouldReceive('get')->andReturnUsing(function (string $key, array $replace = []) {
                $replace = collect($replace)->mapWithKeys(fn ($value, $key) => [":$key" => $value]);

                return str($key)
                    ->explode(' ')
                    ->mapWithKeys(fn ($word, $key) => $replace->has($word) ? $replace->only($word) : [$word => 'mock'])
                    ->implode(' ');
            });
        })
    );
}

TestResponse::macro('assertSeeTitle', function (array|string $sections) {
    return $this->assertSee(sprintf('<title>%s</title>', title(Arr::wrap($sections))), false);
});

TestResponse::macro('assertSeeLink', function (string|array $url) {
    return $this->assertSeeAttr('href', formatUrl($url));
});

TestResponse::macro('assertDontSeeLink', function (string|array $url) {
    return $this->assertDontSeeAttr('href', formatUrl($url));
});

TestResponse::macro('assertSeeHxLink', function (string|array $url, string $method) {
    return $this->assertSeeAttr("hx-$method", formatUrl($url));
});

TestResponse::macro('assertDontSeeHxLink', function (string|array $url, string $method) {
    return $this->assertDontSeeAttr("hx-$method", formatUrl($url));
});

TestResponse::macro('assertSeeForm', function (string|array $action) {
    return $this->assertSeeAttr('action', formatUrl($action));
});

TestResponse::macro('assertSeeInput', function (string $name, ?string $value = null) {
    if (isset($value)) {
        $this->assertSeeAttr('value', $value);
    }

    return $this->assertSeeAttr('name', $name);
});

TestResponse::macro('assertSeeAttr', function (string $attr, string $value) {
    return $this->assertSee("$attr=\"$value\"", false);
});

TestResponse::macro('assertDontSeeAttr', function (string $attr, string $value) {
    return $this->assertDontSee("$attr=\"$value\"", false);
});
