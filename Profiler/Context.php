<?php

namespace Inviqa\LaunchDarklyBundle\Profiler;

class Context
{
    public $type;
    public $backtrace;
    public $onService;
    public $offService;
    public $template;
}