<?php

namespace Inviqa\LaunchDarklyBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ToggledServicePass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        foreach ($container->findTaggedServiceIds('inviqa_launchdarkly.toggle') as $id => $tags) {
            foreach ($tags as $attributes) {

                $default = isset($attributes['default']) ? $attributes['default'] : false;
                $get = $this->get($attributes, $id);

                $container->getDefinition($id)
                    ->setFactory([new Reference('inviqa_launchdarkly.toggled_service_factory'), 'get'])
                    ->setArguments([$get('flag'), $get('active-id'), $get('inactive-id'), $default])
                ;
            }
        }
    }

    private function get($array, $id)
    {
        return function ($key) use ($array, $id) {
            if (isset($array[$key])) {
                return $array[$key];
            }

            throw new \InvalidArgumentException(
                "The $key attribute was not set on the inviqa_launchdarkly.toggle tag on the $id service"
            );
        };
    }

}