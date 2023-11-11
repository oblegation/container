<?php

namespace oblegation\container\ioc\interface;

interface ProxyClient
{
    public function getProxyInstance(mixed $classOrInstance):object;
}