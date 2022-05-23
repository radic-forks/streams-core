<?php

namespace Streams\Tests\Core\Integration\Field\Types;

use Streams\Core\Field\Decorator\DecimalDecorator;
use Streams\Core\Field\Types\DecimalFieldType;
use Streams\Core\Support\Facades\Streams;
use Streams\Tests\Core\Integration\CoreTestCase;

class DecimalFieldTypeTest extends CoreTestCase
{
    public function test_casts_to_decimal()
    {
        $field = new DecimalFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertSame(100.0, $field->cast("100"));

        $this->assertSame(1.2, $field->cast(1.2));

        $this->assertSame(-2.4, $field->cast(-2.4));

        $this->assertSame(1234.0, $field->cast("1,234"));

        $this->assertSame(1234.5, $field->cast("1,234.50"));

        $this->assertSame(-1234.5, $field->cast("-1,234.50"));

        $this->assertSame(-1234.5, $field->restore("-1,234.50"));
    }

    public function test_it_stores_as_float()
    {
        $field = new DecimalFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertSame(100.0, $field->modify("100"));
    }

    public function test_it_returns_decimal_decorator()
    {
        $field = new DecimalFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertInstanceOf(DecimalDecorator::class, $field->decorate(1.2));
    }
}
