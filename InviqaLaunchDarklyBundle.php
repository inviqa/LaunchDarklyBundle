<?php

namespace Inviqa\LaunchDarklyBundle;

use Inviqa\LaunchDarklyBundle\Client\StaticClient;
use Inviqa\LaunchDarklyBundle\ExpressionLanguage\FlagProvider;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class InviqaLaunchDarklyBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addExpressionLanguageProvider(new FlagProvider());
    }

    public function boot()
    {
        parent::boot();
        StaticClient::setClient(function() { return $this->container->get('inviqa_launchdarkly.client'); });
    }

}