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

    public function variation($key, $default = false, Context $context = null)
    {
        return $this->inner->variation($key, $default, Context::fromCode(debug_backtrace(2)));
    }

}
