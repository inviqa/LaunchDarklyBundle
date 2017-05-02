<?php

namespace Inviqa\LaunchDarklyBundle\Client\ExplicitUser;

use Inviqa\LaunchDarklyBundle\Profiler\Context;
use LaunchDarkly\LDUser;

class ContextAddingClient implements ExplicitUserClient
{
    private $inner;

    public function __construct(ExplicitUserClient $inner)
    {
        $this->inner = $inner;
    }    

    public function variation($key, LDUser $user, $default = false, Context $context = null)
    {
        return $this->inner->variation($key, $user, $default, Context::fromCode(debug_backtrace(2)));
    }

}
