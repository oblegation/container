<?php

namespace oblegation\container\lib;

use oblegation\container\lib\interface\ContainerInterface;
use ReflectionFunction;
use Throwable;

class Container implements ContainerInterface
{

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
        }

        if ($containerVessel[$containerId] instanceof $configDocument[$containerId]["class"]){
            return $containerVessel[$containerId];
        }else{
            return null;
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

                    if (array_key_exists($id, $containerVessel) || $containerVessel[$id] instanceof $type){

                        $args[$id] = $containerVessel[$id];

                    }elseif (array_key_exists($id, $configDocument)){

                        $this->loadContainer($id, $containerVessel, $configDocument);

                    }else{
                        return false;
                    }
                }

                $containerVessel[$containerId] = $builder->invokeArgs($args);
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
}