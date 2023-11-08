<?php

namespace oblegation\container\MaritimeInterface;

use oblegation\container\vessel\ApplicationVessel;
use oblegation\container\vessel\WebApplicationVessel;

interface MaritimeInterface
{
    public function getWebApplicationVessel(array $config = array()):WebApplicationVessel;

    public function getApplicationVessel(array $config = array()):ApplicationVessel;
}