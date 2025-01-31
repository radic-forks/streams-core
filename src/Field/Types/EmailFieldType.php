<?php

namespace Streams\Core\Field\Types;

use Streams\Core\Field\Field;
use Streams\Core\Field\Schema\EmailSchema;
use Streams\Core\Field\Decorator\EmailDecorator;

class EmailFieldType extends Field
{
    public function cast($value)
    {
        if (filter_var($value, FILTER_VALIDATE_EMAIL) === false) {
            return null;
        }

        return (string) $value;
    }
    
    public function modify($value)
    {
        return $this->cast($value);
    }

    public function restore($value)
    {
        return $this->cast($value);
    }

    public function getDecoratorName()
    {
        return EmailDecorator::class;
    }

    // public function getSchemaName()
    // {
    //     return EmailSchema::class;
    // }

    // public function generate()
    // {
    //     return $this->generator()->email();
    // }
}
