<?php

namespace Streams\Tests\Core\Integration\Asset;

use Illuminate\Support\Facades\URL;
use Streams\Core\Asset\AssetCollection;
use Streams\Core\Support\Facades\Assets;
use Streams\Tests\Core\Integration\CoreTestCase;

class AssetManagerTest extends CoreTestCase
{
    public function test_it_adds_assets_to_collections()
    {
        Assets::add('styles', 'style.css');

        $this->assertEquals(1, Assets::collection('styles')->count());
    }

    public function test_it_returns_asset_collections()
    {
        Assets::add('scripts', 'theme.js');

        $this->assertInstanceOf(AssetCollection::class, Assets::collection('scripts'));
        $this->assertEquals(['theme.js' => 'theme.js'], Assets::collection('scripts')->all());
    }

    public function test_it_loads_unregistered_assets()
    {
        Assets::load('scripts', 'theme.js');

        $this->assertEquals(['theme.js' => 'theme.js'], Assets::collection('scripts')->all());
    }

    public function test_it_loads_registered_assets()
    {
        Assets::register('theme.js', 'super.js');
        Assets::register('pack.js', ['super.js', 'another.js']);

        Assets::resolve('theme.js');
        Assets::resolve('theme.js');

        Assets::resolve('pack.js');

        $this->assertEquals('https://test.com/example.jpg', Assets::resolve('https://test.com/example.jpg'));
        $this->assertEquals(['super.js', 'another.js'], Assets::resolve('pack.js'));
    }

    public function test_it_returns_inline_asset_tags()
    {
        $content = file_get_contents(public_path('vendor/testing/css/example.css'));

        $this->assertEquals(
            '<style media="all" type="text/css" rel="stylesheet">' . $content . '</style>',
            Assets::inline('vendor/testing/css/example.css')
        );

        $content = file_get_contents(public_path('vendor/testing/js/example.js'));

        $this->assertEquals(
            '<script>' . $content . '</script>',
            Assets::inline('vendor/testing/js/example.js')
        );

        $this->assertEquals('', Assets::inline('vendor/streams/core/tests/testing.foo'));
    }

    public function test_it_returns_asset_contents()
    {
        $content = file_get_contents(public_path('vendor/testing/css/example.css'));

        $this->assertEquals($content, Assets::contents('vendor/testing/css/example.css'));
    }

    public function test_it_returns_asset_urls()
    {
        $this->assertEquals(URL::to('testing.css'), Assets::url('testing.css'));
    }

    public function test_it_returns_asset_tags()
    {
        $this->assertEquals(
            '<link media="all" type="text/css" rel="stylesheet" href="vendor/testing/css/example.css"/>',
            Assets::tag('vendor/testing/css/example.css')
        );

        $this->assertEquals(
            '<script src="vendor/testing/js/example.js"></script>',
            Assets::tag('vendor/testing/js/example.js')
        );
    }

    public function test_to_string_returns_empty_string()
    {
        $this->assertEquals('', (string) Assets::load('testing', 'testing.css'));
    }
}
