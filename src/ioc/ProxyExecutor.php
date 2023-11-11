<?php

namespace oblegation\container\ioc;

use oblegation\container\ioc\interface\ProxyClient;
use oblegation\container\vessel\Interface\VesselInterface;
use ReflectionException;

class ProxyExecutor implements ProxyClient
{
    private ReflectionTypeStrategy $reflectionTypeStrategy;


    public function __construct(VesselInterface $vessel)
    {
        $this->reflectionTypeStrategy = new ReflectionTypeStrategy($vessel);
    }

    /**
     * @throws ReflectionException
     */
    public function getProxyInstance(mixed $classOrInstance): object
    {
        //获取参数类型
        $type = gettype($classOrInstance);

        //设置策略状态
        $this->reflectionTypeStrategy->setStatus($type);

        //执行策略
        return $this->reflectionTypeStrategy->getInstance($classOrInstance);
    }
}