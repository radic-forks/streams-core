<?php

namespace Streams\Tests\Core\Integration\Field\Types;

use Carbon\Carbon;
use Streams\Core\Field\Decorator\DateDecorator;
use Streams\Core\Field\Types\DateFieldType;
use Streams\Core\Support\Facades\Streams;
use Streams\Tests\Core\Integration\CoreTestCase;

class DateFieldTypeTest extends CoreTestCase
{
    public function test_it_casts_to_carbon_values()
    {
        $entry = Streams::repository('films')->find(4);

        $this->assertInstanceOf(Carbon::class, $entry->created);

        $field = new DateFieldType([
            'stream' => Streams::make('films')
        ]);

        $timestamp = (new Carbon('2021-01-01'))->timestamp;

        $this->assertInstanceOf(Carbon::class, $field->restore($timestamp));
    }

    public function test_it_casts_carbon_to_carbon()
    {
        $field = new DateFieldType([
            'stream' => Streams::make('films')
        ]);

        $carbon = new Carbon('2021-01-01');

        $this->assertInstanceOf(Carbon::class, $field->cast($carbon));
    }

    public function test_it_casts_datetime_to_carbon()
    {
        $field = new DateFieldType([
            'stream' => Streams::make('films')
        ]);

        $instance = new \Datetime('2021-01-01');

        $this->assertInstanceOf(Carbon::class, $field->cast($instance));
    }

    public function test_it_casts_timestamps_to_carbon()
    {
        $field = new DateFieldType([
            'stream' => Streams::make('films')
        ]);

        $timestamp = (new Carbon('2021-01-01'))->timestamp;

        $this->assertInstanceOf(Carbon::class, $field->cast($timestamp));
    }

    public function test_it_casts_strings_to_carbon()
    {
        $field = new DateFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertInstanceOf(Carbon::class, $field->cast('2021-01-01'));
        $this->assertInstanceOf(Carbon::class, $field->cast('yesterday'));
    }

    public function test_it_stores_as_date_string()
    {
        $field = new DateFieldType([
            'stream' => Streams::make('films')
        ]);

        $date = '2021-01-01';

        $this->assertSame($date, $field->modify(new Carbon($date)));
    }

    public function test_it_restores_as_carbon()
    {
        $field = new DateFieldType([
            'stream' => Streams::make('films')
        ]);

        $date = '2021-01-01';

        $this->assertInstanceOf(Carbon::class, $field->restore($date));
    }

    public function test_it_casts_default_value_to_carbon()
    {
        $field = new DateFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertInstanceOf(Carbon::class, $field->default('now'));
    }

    public function test_it_returns_date_decorator()
    {
        $field = new DateFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertInstanceOf(DateDecorator::class, $field->decorate('2021-01-01'));
    }
}
