<?php

namespace oblegation\container\vessel;

use oblegation\container\lib\Container;
use oblegation\container\vessel\Interface\vesselInterface;
use oblegation\container\vessel\Interface\WebInterface;

class WebApplicationVessel implements VesselInterface, WebInterface
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

    /**
     * @return void
     */
    public function sessionStart(): void
    {
        foreach ($this->configDocument as $item => $document){
            if ($document["scope"] == "session"){
                $this->container->injectContainer($item,$this->containerVessel,$this->configDocument);
            }
        }
    }

    /**
     * @return void
     */
    public function sessionClose(): void
    {
        foreach ($this->configDocument as $item => $document){
            if ($document["scope"] == "session"){
                $this->container->removeContainer($item,$this->containerVessel);
            }
        }
    }

    /**
     * @return void
     */
    public function requestStart(): void
    {
        foreach ($this->configDocument as $item => $document){
            if ($document["scope"] == "request"){
                $this->container->injectContainer($item,$this->containerVessel,$this->configDocument);
            }
        }
    }

    /**
     * @return void
     */
    public function requestClose(): void
    {
        foreach ($this->configDocument as $item => $document){
            if ($document["scope"] == "request"){
                $this->container->removeContainer($item,$this->containerVessel);
            }
        }
    }

    /**
     * @return void
     */
    public function workStart(): void
    {
        foreach ($this->configDocument as $item => $document){
            if ($document["scope"] == "worker"){
                $this->container->injectContainer($item,$this->containerVessel,$this->configDocument);
            }
        }
    }

    /**
     * @return void
     */
    public function workClose(): void
    {
        foreach ($this->configDocument as $item => $document){
            if ($document["scope"] == "worker"){
                $this->container->removeContainer($item,$this->containerVessel);
            }
        }
    }
}