<?php

namespace oblegation\container\lib;

use oblegation\container\ioc\ProxyExecutor;
use oblegation\container\lib\interface\ContainerInterface;
use oblegation\container\vessel\Interface\VesselInterface;
use ReflectionFunction;
use Throwable;

class Container implements ContainerInterface
{
    private ProxyExecutor $proxyExecutor;

    public function __construct(VesselInterface $vessel)
    {
        $this->proxyExecutor = new ProxyExecutor($vessel);
    }

    /**
     * @param string $containerId
     * @param array $containerVessel
     * @param array $configDocument
     * @return object|null
     */
    public function getApplicationContainer(string $containerId, array &$containerVessel, array &$configDocument): object|null
    {
        if (!array_key_exists($containerId, $containerVessel)) {
            if ($this->loadContainer($containerId, $containerVessel, $configDocument)){
                return $containerVessel[$containerId];
            }else{
                return null;
            }
        }else{
            if ($containerVessel[$containerId] instanceof $configDocument[$containerId]["class"]){
                return $containerVessel[$containerId];
            }else{
                return null;
            }
        }
    }

    /**
     * @param string $containerId
     * @param array $containerVessel
     * @param array $configDocument
     * @return bool
     */
    private function loadContainer(string $containerId, array &$containerVessel, array &$configDocument):bool
    {
        if(array_key_exists($containerId, $configDocument)){

            $document = $configDocument[$containerId];

            $args = array();

            try {
                $builder = new ReflectionFunction($document["builder"]);

                $parameters = $builder->getParameters();

                foreach ($parameters as $parameter){

                    $id = $parameter->getName();

                    $type = $parameter->getType();

                    if (array_key_exists($id, $containerVessel)){

                        if ($containerVessel[$id]::class == $type){

                            $args[$id] = $containerVessel[$id];
                        }else{
                            return false;
                        }

                    }elseif (array_key_exists($id, $configDocument)){

                        if ($this->loadContainer($id,$containerVessel, $configDocument)){

                            if ($containerVessel[$id]::class == $type){

                                $args[$id] = $containerVessel[$id];
                            }else{
                                return false;
                            }
                        }else {
                            return false;
                        }
                    }else{
                        return false;
                    }
                }

                $containerVessel[$containerId] = $this->proxyExecutor->getProxyInstance($builder->invokeArgs($args));
            }catch (Throwable){
                return false;
            }
        }
        return true;
    }

    /**
     * @param string $containerId
     * @param array $configDocument
     * @param array $document
     * @return bool
     */
    public function registerDocument(string $containerId, array &$configDocument, array $document):bool{
        if (!array_key_exists($containerId, $configDocument)){

            $configDocument[$containerId] = $document;
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param string $containerId
     * @param array $containerVessel
     * @param array $configDocument
     * @return bool
     */
    public function injectContainer(string $containerId, array &$containerVessel, array &$configDocument): bool
    {
        if ($this->getApplicationContainer($containerId,$containerVessel,$configDocument) != null){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param array $containerVessel
     * @param string $containerId
     * @return bool
     */
    public function removeContainer(string $containerId, array &$containerVessel): bool
    {
        if (array_key_exists($containerId, $containerVessel)){
            unset($containerVessel[$containerId]);
            return true;
        }
        return false;
    }
}