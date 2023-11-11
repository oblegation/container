<?php

namespace oblegation\container\ioc\annotation;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Value
{
    private mixed $value;

    public function __construct(mixed $value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getValue(): mixed
    {
        return $this->value;
    }
}