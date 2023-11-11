<?php

namespace oblegation\container\ioc\interface;

use ReflectionProperty;

interface InstanceClient
{
    public function getInstance(mixed $classOrInstance):object;

    public function getInstanceWithNoInstance(string $className):object;

    public function fillProperty(string $className, object $propertyInstance, ReflectionProperty $reflectionProperty, object $instance):void;

    public function getInstanceWithInstance(string $className,object $instance):object;
}