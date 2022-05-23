<?php

namespace Streams\Tests\Core\Integration\Field\Types;

use Streams\Core\Field\Decorator\EmailDecorator;
use Streams\Core\Field\Types\EmailFieldType;
use Streams\Core\Support\Facades\Streams;
use Streams\Tests\Core\Integration\CoreTestCase;

class EmailFieldTypeTest extends CoreTestCase
{
    public function test_it_casts_to_string()
    {
        $field = new EmailFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertSame('test@email.com', $field->cast('test@email.com'));
        $this->assertSame('test@email.com', $field->restore('test@email.com'));
    }

    public function test_it_casts_non_emails_to_null()
    {
        $field = new EmailFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertNull($field->cast('test'));
    }

    public function test_it_stores_as_string()
    {
        $field = new EmailFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertSame('test@email.com', $field->modify('test@email.com'));
    }

    public function test_it_returns_email_decorator()
    {
        $field = new EmailFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertInstanceOf(EmailDecorator::class, $field->decorate('test@email.com'));
    }
}
