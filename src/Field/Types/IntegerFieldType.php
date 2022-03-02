<?php

namespace Streams\Core\Field\Types;

use Streams\Core\Field\Field;
use Streams\Core\Field\Value\IntegerValue;
use Streams\Core\Field\Schema\IntegerSchema;

class IntegerFieldType extends Field
{
    protected $__attributes = [
        'rules' => [
            'numeric',
            'integer',
        ],
    ];

    public function cast($value): int
    {
        if (is_string($value)) {
            $value = preg_replace('/[^\da-z\.\-]/i', '', $value);
        }

        return intval($value);
    }

    public function modify($value)
    {
        return $this->cast($value);
    }

    public function restore($value)
    {
        return $this->cast($value);
    }

    public function default($value)
    {
        if ($value == 'increment') {
            return $this->getNextIncrementValue();
        }

        return (int) $value;
    }

    public function getPresenterName()
    {
        return IntegerValue::class;
    }

    public function getSchemaName()
    {
        return IntegerSchema::class;
    }

    public function generate(): int
    {
        return $this->generator()->randomNumber();
    }

    public function getNextIncrementValue()
    {
        $last = $this->stream->entries()->orderBy($this->handle, 'DESC')->first();

        if (!$last) {
            return 1;
        }

        return $last->{$this->handle} + 1;
    }
}
