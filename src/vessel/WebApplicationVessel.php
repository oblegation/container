<?php

namespace oblegation\container\vessel;

use oblegation\container\vessel\vesselInterface\vesselInterface;

class WebApplicationVessel implements VesselInterface
{
    private array $configDocument;

    private array $containerVessel = array();

    /**
     * @param array $configDocument
     */
    public function __construct(array $configDocument = array()){

        $this->configDocument = $configDocument;
    }

    public function getContainer(string $containerId): object
    {
        // TODO: Implement getContainer() method.
    }

    public function registerContainer(string $containerId, array $document): void
    {
        // TODO: Implement registerContainer() method.
    }
}