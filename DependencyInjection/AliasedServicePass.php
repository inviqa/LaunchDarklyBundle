<?php

namespace Inviqa\LaunchDarklyBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class AliasedServicePass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        foreach ($container->getAliases() as $definitionId => $target) {
            if (preg_match('/(.*)\?(.*):(.*)/', (string) $target, $matches)) {

                $definition = new Definition('DummyClass', [$matches[1], $matches[2], $matches[3]]);
                $definition->setFactory([new Reference('inviqa_launchdarkly.toggled_service_factory'), 'get']);
                $container->setDefinition($definitionId, $definition);
            }
        }
    }

}