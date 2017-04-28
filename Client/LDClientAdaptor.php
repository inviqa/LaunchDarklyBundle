<?php

namespace Inviqa\LaunchDarklyBundle\Client;

use LaunchDarkly\LDClient;

class LDCLientAdaptor extends ClientDecorator
{
    public function __construct(LDClient $inner)
    {
        $this->inner = $inner;
    }
}
