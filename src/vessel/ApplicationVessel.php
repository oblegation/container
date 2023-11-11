<?php

namespace oblegation\container\vessel;

use oblegation\container\lib\Container;
use oblegation\container\vessel\Interface\vesselInterface;

class ApplicationVessel implements VesselInterface
{
    private array $configDocument;

    private array $containerVessel = array();

    private Container $container;

    /**
     * @param array $configDocument
     */
    public function __construct(array $configDocument = array()){

        $this->configDocument = $configDocument;

        $this->container = new Container($this);
    }

    /**
     * @param string $containerId
     * @return object|null
     */
    public function getContainer(string $containerId): object | null
    {
        return $this->container->getApplicationContainer($containerId, $this->containerVessel, $this->configDocument);
    }

    /**
     * @param string $containerId
     * @param array $document
     * @return bool
     */
    public function registerContainer(string $containerId, array $document): bool
    {
        if ($this->container->registerDocument($containerId, $this->configDocument, $document)){
            return true;
        }
        return false;
    }
}