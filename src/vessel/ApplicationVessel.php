<?php

namespace oblegation\container\vessel;

use oblegation\container\lib\Container;
use oblegation\container\vessel\vesselInterface\vesselInterface;

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

        $this->container = new Container();
    }

    /**
     * @param string $containerId
     * @return object
     */
    public function getContainer(string $containerId): object
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