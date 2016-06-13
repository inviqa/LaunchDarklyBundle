<?php

namespace Inviqa\LaunchDarklyBundle\Twig;

use LaunchDarkly\LDClient;
use LaunchDarkly\LDUser;

class FlagExtension extends \Twig_Extension
{
    private $ldClient;

    public function __construct(LDClient $ldClient)
    {
        $this->ldClient = $ldClient;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('isFlagOn', array($this, 'isFlagOn')),
        ];
    }

    public function isFlagOn($key, $userId)
    {
        return $this->ldClient->getFlag($key, new LDUser($userId));
    }
    
    public function getName()
    {
        return 'launch_darkly_flag';
    }
    
    
}