<?php

namespace Inviqa\LaunchDarklyBundle\DependencyInjection;

use Inviqa\LaunchDarklyBundle\Client\SimpleClient;
use Inviqa\LaunchDarklyBundle\Profiler\Context;
use Symfony\Component\DependencyInjection\Container;

class ToggledServiceFactory
{
    private $container;
    private $client;

    public function __construct(Container $container, SimpleClient $client)
    {
        $this->container = $container;
        $this->client = $client;
    }
    
    public function get($flag, $onId, $offId, $default = false)
    {
        if ($this->client->isOn($flag, $default, Context::fromService($onId, $offId))) {
            return $this->container->get($onId);
        }
        
        return $this->container->get($offId);
    }

}