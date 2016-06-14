<?php

namespace Inviqa\LaunchDarklyBundle;

use Inviqa\LaunchDarklyBundle\ExpressionLanguage\FlagProvider;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class InviqaLaunchDarklyBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addExpressionLanguageProvider(new FlagProvider());
    }
}