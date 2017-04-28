<?php

namespace Inviqa\LaunchDarklyBundle\Client;

use LaunchDarkly\LDClient;

class LDClientAdaptor extends ClientDecorator
{
    public function __construct(LDClient $inner)
    {
        $this->inner = $inner;
    }
}
