<?php

namespace oblegation\container\ioc;

use Exception;
use oblegation\container\ioc\annotation\AutoWired;
use oblegation\container\ioc\annotation\Value;
use oblegation\container\ioc\interface\InstanceClient;
use oblegation\container\vessel\Interface\VesselInterface;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

class ReflectionTypeStrategy implements InstanceClient
{
    private string $status;

    private VesselInterface $vessel;

    public function __construct(VesselInterface $vessel){
        $this->vessel = $vessel;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @throws ReflectionException
     */
    public function getInstance(mixed $classOrInstance): object
    {
        if ($this->status == "string")
            return $this->getInstanceWithNoInstance($classOrInstance);
        else
            return $this->getInstanceWithInstance($classOrInstance::class,$classOrInstance);
    }

    /**
     * @throws ReflectionException
     */
    public function getInstanceWithNoInstance(string $className): object
    {
        $reflectionClass = new ReflectionClass($className);

        $reflectionInstance = $reflectionClass->newInstance();

        return $this->extracted($reflectionClass, $reflectionInstance);
    }

    /**
     * @throws ReflectionException
     */
    public function getInstanceWithInstance(string $className, object $instance): object
    {
        $reflectionClass = new ReflectionClass($className);

        $reflectionInstance = $instance;

        return $this->extracted($reflectionClass, $reflectionInstance);
    }

    /**
     * @throws ReflectionException
     */
    public function fillProperty(string $className, object $propertyInstance, ReflectionProperty $reflectionProperty, object $instance): void
    {
        $object = $this->getInstanceWithInstance($className, $propertyInstance);

        $reflectionProperty->setValue($instance, $object);
    }

    /**
     * @param ReflectionClass $reflectionClass
     * @param object $reflectionInstance
     * @return object
     * @throws ReflectionException|Exception
     */
    public function extracted(ReflectionClass $reflectionClass, object $reflectionInstance): object
    {
        $properties = $reflectionClass->getProperties();

        if (!empty($properties)) {

            foreach ($properties as $property) {

                $type = $property->getType()->getName();

                $name = $property->getName();

                $attributes = $property->getAttributes();

                if (!in_array($type, array("string", "int", "bool", "float", "array"))) {

                    foreach ($attributes as $attribute) {

                        $attrName = $attribute->getName();

                        if ($attrName == AutoWired::class) {

                            $property->setValue($reflectionInstance,$this->vessel->getContainer($name));
                        }
                    }
                } else {

                    foreach ($attributes as $attribute) {

                        $attrName = $attribute->getName();

                        if ($attrName == Value::class) {

                            $value = $attribute->newInstance()->getValue();

                            $property->setValue($reflectionInstance, $value);
                        }
                    }
                }
            }
        }
        return $reflectionInstance;
    }
}