<?php

namespace Inviqa\LaunchDarklyBundle;

use Inviqa\LaunchDarklyBundle\Client\StaticClient;
use Inviqa\LaunchDarklyBundle\Client\ExplicitUser\StaticClient as UserStaticClient;
use Inviqa\LaunchDarklyBundle\DependencyInjection\AliasedServicePass;
use Inviqa\LaunchDarklyBundle\DependencyInjection\ToggledServicePass;
use Inviqa\LaunchDarklyBundle\ExpressionLanguage\FlagProvider;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class InviqaLaunchDarklyBundle extends Bundle
{
    
    public function build(ContainerBuilder $container)
    {
        $container->addExpressionLanguageProvider(new FlagProvider());
        $container->addCompilerPass(new ToggledServicePass(), PassConfig::TYPE_BEFORE_OPTIMIZATION);
        $container->addCompilerPass(new AliasedServicePass(), PassConfig::TYPE_BEFORE_OPTIMIZATION);
    }

    public function boot()
    {
        parent::boot();
        StaticClient::setClient(
            function () {
                return $this->container->get('inviqa_launchdarkly.client');
            }
        );

        UserStaticClient::setClient(
            function () {
                return $this->container->get('inviqa_launchdarkly.user_client');
            }
        );
    }

}