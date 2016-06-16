<?php

namespace Inviqa\LaunchDarklyBundle\Twig;

use Inviqa\LaunchDarklyBundle\Client\Client;
use LaunchDarkly\LDUser;

class FlagExtension extends \Twig_Extension
{
    private $ldClient;

    public function __construct(Client $ldClient)
    {
        $this->ldClient = $ldClient;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('isFlagOn', array($this, 'isFlagOn')),
        ];
    }

    public function isFlagOn($key)
    {
        return $this->ldClient->isOn($key);
    }
    
    public function getName()
    {
        return 'launch_darkly_flag';
    }
    
    
}