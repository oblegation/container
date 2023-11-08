<?php

namespace oblegation\container\vessel\vesselInterface;

interface vesselInterface
{
    public function getContainer(string $containerId):object;

    public function registerContainer(string $containerId, array $document):bool;
}