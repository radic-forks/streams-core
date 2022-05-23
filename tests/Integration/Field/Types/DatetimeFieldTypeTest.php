<?php

namespace Streams\Tests\Core\Integration\Field\Types;

use Carbon\Carbon;
use Streams\Core\Field\Decorator\DatetimeDecorator;
use Streams\Core\Field\Types\DatetimeFieldType;
use Streams\Core\Support\Facades\Streams;
use Streams\Tests\Core\Integration\CoreTestCase;

class DatetimeFieldTypeTest extends CoreTestCase
{
    public function test_it_casts_carbon_to_carbon()
    {
        $field = new DatetimeFieldType([
            'stream' => Streams::make('films')
        ]);

        $carbon = new Carbon('2021-01-01 09:30:00');

        $this->assertInstanceOf(Carbon::class, $field->cast($carbon));
        $this->assertInstanceOf(Carbon::class, $field->restore($carbon));
    }

    public function test_it_casts_datetime_to_carbon()
    {
        $field = new DatetimeFieldType([
            'stream' => Streams::make('films')
        ]);

        $instance = new \Datetime('2021-01-01 09:30:00');

        $this->assertInstanceOf(Carbon::class, $field->cast($instance));
    }

    public function test_it_casts_timestamps_to_carbon()
    {
        $field = new DatetimeFieldType([
            'stream' => Streams::make('films')
        ]);

        $timestamp = (new Carbon('2021-01-01 9:30'))->timestamp;

        $this->assertInstanceOf(Carbon::class, $field->cast($timestamp));
    }

    public function test_it_casts_strings_to_carbon()
    {
        $field = new DatetimeFieldType([
            'stream' => Streams::make('films')
        ]);

        $value = '2021-01-01 9:30';

        $this->assertInstanceOf(Carbon::class, $field->cast($value));
    }

    public function test_it_stores_as_datetime_string()
    {
        $field = new DatetimeFieldType([
            'stream' => Streams::make('films')
        ]);

        $value = '2021-01-01 09:30:01';

        $this->assertSame($value, $field->modify(new Carbon($value)));
    }

    public function test_it_returns_datetime_decorator()
    {
        $field = new DatetimeFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertInstanceOf(DatetimeDecorator::class, $field->decorate('2021-01-01 9:30'));
    }
}
