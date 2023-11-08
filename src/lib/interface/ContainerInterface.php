<?php

namespace oblegation\container\lib\interface;

interface ContainerInterface
{
    public function getApplicationContainer(string $containerId, array &$containerVessel, array &$configDocument):object | null;
}