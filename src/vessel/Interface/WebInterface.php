<?php

namespace oblegation\container\vessel\Interface;

interface WebInterface
{
    public function workStart():void;

    public function workClose():void;

    public function sessionStart():void;

    public function sessionClose():void;

    public function requestStart():void;

    public function requestClose():void;
}