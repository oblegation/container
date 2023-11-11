<?php

namespace oblegation\container\ioc\annotation;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class AutoWired
{
    public function __construct(){

    }
}