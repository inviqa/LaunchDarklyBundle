<?php

namespace Inviqa\LaunchDarklyBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('inviqa_launch_darkly');

        $rootNode
            ->isRequired()
            ->children()
                ->scalarNode('api_key')
                    ->isRequired()
                ->end()
                ->scalarNode('base_uri')->end()
                ->scalarNode('user_factory_service')->defaultValue('inviqa_launchdarkly.simple_user_factory')->end()
                ->scalarNode('user_id_provider_service')->defaultValue('inviqa_launchdarkly.session_id_provider')->end()
                ->scalarNode('feature_requester_class')->end()
                ->integerNode('timeout')->end()
                ->integerNode('connect_timeout')->end()
                ->integerNode('capacity')->end()
                ->booleanNode('events')->end()
                ->arrayNode('defaults')->useAttributeAsKey('flag')->prototype('boolean')->end()->end()
            ->end();

        return $treeBuilder;
    }
}
