<?php

namespace oblegation\container\vessel\Interface;

interface VesselInterface
{
    public function getContainer(string $containerId):object | null;

    public function registerContainer(string $containerId, array $document):bool;
}