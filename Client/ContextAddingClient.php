<?php

namespace Inviqa\LaunchDarklyBundle\Client;

use Inviqa\LaunchDarklyBundle\Profiler\Context;

class ContextAddingClient implements SimpleClient
{
    private $inner;

    public function __construct(SimpleClient $inner)
    {
        $this->inner = $inner;
    }    

    public function isOn($key, $default = false, Context $context = null)
    {
        return $this->inner->isOn($key, $default, Context::fromCode(debug_backtrace(2)));
    }

}
