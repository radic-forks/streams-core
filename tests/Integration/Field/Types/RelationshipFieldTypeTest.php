<?php

namespace Streams\Tests\Core\Integration\Field\Types;

use Streams\Core\Entry\Contract\EntryInterface;
use Streams\Core\Field\Types\RelationshipFieldType;
use Streams\Core\Support\Facades\Streams;
use Streams\Tests\Core\Integration\CoreTestCase;

class RelationshipFieldTypeTest extends CoreTestCase
{
    public function test_it_stores_the_key_value()
    {
        $field = new RelationshipFieldType([
            'stream' => Streams::make('films'),
            'config' => [
                'related' => 'films',
            ]
        ]);

        $entry = Streams::repository('films')->find(4);

        $this->assertSame(4, $field->modify($entry));
        $this->assertSame(4, $field->modify('4'));
        $this->assertSame(4, $field->modify(4));

        $this->assertSame('test', $field->modify('test'));
    }

    public function test_it_restores_an_entry_interface()
    {
        $field = new RelationshipFieldType([
            'stream' => Streams::make('films'),
            'config' => [
                'related' => 'films',
            ]
        ]);

        $this->assertInstanceOf(
            EntryInterface::class,
            $field->decorate(Streams::repository('films')->find('4'))
        );

        $this->assertInstanceOf(EntryInterface::class, $field->decorate('4'));
    }
}
