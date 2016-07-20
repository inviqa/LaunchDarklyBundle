<?php

namespace Inviqa\LaunchDarklyBundle\Profiler;

class Context
{

    private $type;
    private $details;

    private function __construct($type, $details)
    {
        $this->type = $type;
        $this->details = $details;
    }

    public static function fromTemplate($templateName)
    {
        return new self('template', $templateName);
    }

    public static function fromService($onService, $offService)
    {
        return new self('service', "$onService / $offService");
    }

    public static function fromCode($backtrace)
    {
        return new self('code', $backtrace[1]['file'] . ':' . $backtrace[1]['line']);
    }

    public function getType()
    {
        return $this->type;
    }

    public function getDetails()
    {
        return $this->details;
    }

}