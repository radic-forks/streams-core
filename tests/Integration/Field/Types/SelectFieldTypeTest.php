<?php

namespace Streams\Tests\Core\Integration\Field\Types;

use Streams\Core\Field\Decorator\SelectDecorator;
use Streams\Core\Field\Types\SelectFieldType;
use Streams\Core\Support\Facades\Streams;
use Streams\Tests\Core\Integration\CoreTestCase;

class SelectFieldTypeTest extends CoreTestCase
{
    public function test_it_supports_enumerated_options()
    {
        $field = new SelectFieldType([
            'stream' => Streams::make('films'),
            'config' => [
                'options' => [
                    'foo' => 'Foo',
                    'bar' => 'Bar'
                ],
            ],
        ]);

        $this->assertSame(['foo' => 'Foo', 'bar' => 'Bar'], $field->options());
    }

    public function test_it_supports_callable_options()
    {
        $field = new SelectFieldType([
            'stream' => Streams::make('films'),
            'config' => [
                'options' => CallableSelectOptions::class,
            ],
        ]);

        $this->assertSame(['baz' => 'Baz', 'qux' => 'Qux'], $field->options());
    }

    public function test_it_returns_select_decorator()
    {
        $field = new SelectFieldType([
            'stream' => Streams::make('films'),
        ]);

        $this->assertInstanceOf(SelectDecorator::class, $field->decorate('foo'));
    }

    public function test_it_automates_array_validation()
    {
        $field = new SelectFieldType([
            'stream' => Streams::make('films'),
            'config' => [
                'options' => [
                    'foo' => 'Foo',
                    'bar' => 'Bar'
                ],
            ],
        ]);

        $this->assertSame(['in:foo,bar'], $field->rules());
    }
}

class CallableSelectOptions
{
    public function __invoke()
    {
        return [
            'baz' => 'Baz',
            'qux' => 'Qux',
        ];
    }
}
