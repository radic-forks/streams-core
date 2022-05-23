<?php

namespace Streams\Tests\Core\Integration\Field\Types;

use Illuminate\Support\Collection;
use Streams\Core\Entry\Entry;
use Streams\Core\Field\Decorator\ArrayDecorator;
use Streams\Core\Field\Types\ArrayFieldType;
use Streams\Core\Support\Facades\Streams;
use Streams\Tests\Core\Integration\CoreTestCase;

class ArrayFieldTypeTest extends CoreTestCase
{
    public function test_it_casts_json_to_array()
    {
        $field = new ArrayFieldType([
            'stream' => Streams::make('films')
        ]);

        $array = ['foo' => 'Foo', 'bar' => 'Bar'];

        $json = json_encode($array);

        $this->assertSame($array, $field->cast($json));
    }

    public function test_it_casts_serialized_to_array()
    {
        $field = new ArrayFieldType([
            'stream' => Streams::make('films')
        ]);

        $array = ['foo' => 'Foo', 'bar' => 'Bar'];

        $serialized = serialize($array);

        $this->assertSame($array, $field->cast($serialized));
    }

    public function test_it_casts_arbitrary_string_to_array()
    {
        $field = new ArrayFieldType([
            'stream' => Streams::make('films')
        ]);

        $value = 'I am not an array.';

        $this->assertSame([$value], $field->cast($value));
    }

    public function test_it_returns_array_decorator()
    {
        $field = new ArrayFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertInstanceOf(ArrayDecorator::class, $field->decorate($field, []));
    }

    public function test_it_stores_abstract_types()
    {
        $field = new ArrayFieldType([
            'name' => 'Test Name',
            'stream' => Streams::make('films')
        ]);

        $this->assertSame([[
            '@abstract' => get_class($field),
            'name' => 'Test Name',
        ]], $field->modify([$field]));
    }

    public function test_it_restores_abstract_types()
    {
        $field = new ArrayFieldType([
            'name' => 'Test Name',
            'stream' => Streams::make('films')
        ]);

        $restored = $field->restore($field->modify([$field]));

        $this->assertInstanceOf(ArrayFieldType::class, $restored[0]);

        $this->assertSame('Test Name', $restored[0]->name);
    }

    public function test_it_stores_entries()
    {
        $field = new ArrayFieldType([
            'stream' => Streams::make('films')
        ]);

        $entry = new Entry([
            'name' => 'Test Name',
            'stream' => Streams::make('films')
        ]);

        $this->assertSame([[
            '@stream' => $entry->stream()->id,
            'name' => 'Test Name',
        ]], $field->modify([$entry]));
    }

    public function test_it_restores_entries()
    {
        $field = new ArrayFieldType([
            'stream' => Streams::make('films')
        ]);

        $entry = new Entry([
            'name' => 'Test Name',
            'stream' => Streams::make('films')
        ]);

        $restored = $field->restore($field->modify([$entry]));

        $this->assertInstanceOf(Entry::class, $restored[0]);

        $this->assertSame('Test Name', $restored[0]->name);
    }

    public function test_it_stores_generics()
    {
        $field = new ArrayFieldType([
            'stream' => Streams::make('films')
        ]);

        $entry = json_decode(json_encode([
            'name' => 'Test Name',
        ]));

        $this->assertSame([[
            'name' => 'Test Name',
        ]], $field->modify([$entry]));
    }

    public function test_it_restores_generics_to_array()
    {
        $field = new ArrayFieldType([
            'stream' => Streams::make('films')
        ]);

        $entry = json_decode(json_encode([
            'name' => 'Test Name',
        ]));

        $restored = $field->restore($field->modify([$entry]));

        $this->assertSame([[
            'name' => 'Test Name',
        ]], $restored);
    }

    public function test_it_stores_arrays()
    {
        $field = new ArrayFieldType([
            'stream' => Streams::make('films')
        ]);

        $entry = [
            'name' => 'Test Name',
        ];

        $this->assertSame([[
            'name' => 'Test Name',
        ]], $field->modify([$entry]));
    }

    public function test_it_restores_arrays()
    {
        $field = new ArrayFieldType([
            'stream' => Streams::make('films')
        ]);

        $entry = [
            'Test Name',
        ];

        $restored = $field->restore($field->modify([$entry]));

        $this->assertSame([[
            'Test Name',
        ]], $restored);
    }

    public function test_it_wraps_to_collections()
    {
        $field = new ArrayFieldType([
            'stream' => Streams::make('films'),
            'config' => [
                'wrapper' => 'collection',
            ]
        ]);

        $entry = [
            'Test Name',
        ];

        $restored = $field->restore($field->modify([$entry]));

        $this->assertInstanceOf(Collection::class, $restored);

        $this->assertSame(1, $restored->count());
    }

    public function test_it_wraps_to_custom_collections()
    {
        $field = new ArrayFieldType([
            'stream' => Streams::make('films'),
            'config' => [
                'wrapper' => CustomArrayWrapper::class,
            ]
        ]);

        $entry = [
            'Test Name',
        ];

        $restored = $field->restore($field->modify([$entry, $entry]));

        $this->assertInstanceOf(CustomArrayWrapper::class, $restored);

        $this->assertSame(2, $restored->count());
    }
}

class CustomArrayWrapper extends Collection
{
}
