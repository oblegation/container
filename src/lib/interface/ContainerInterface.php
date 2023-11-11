<?php

namespace oblegation\container\lib\interface;

interface ContainerInterface
{
    public function getApplicationContainer(string $containerId, array &$containerVessel, array &$configDocument):object | null;

    public function injectContainer(string $containerId, array &$containerVessel, array &$configDocument):bool;

    public function removeContainer(string $containerId, array &$containerVessel):bool;
}