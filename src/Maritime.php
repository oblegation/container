<?php

namespace oblegation\container;

use oblegation\container\MaritimeInterface\MaritimeInterface;
use oblegation\container\vessel\ApplicationVessel;
use oblegation\container\vessel\WebApplicationVessel;

class Maritime implements MaritimeInterface
{

    public function getWebApplicationVessel(array $config = array()): WebApplicationVessel
    {
        return new WebApplicationVessel($config);
    }

    public function getApplicationVessel(array $config = array()): ApplicationVessel
    {
        return new ApplicationVessel($config);
    }
}