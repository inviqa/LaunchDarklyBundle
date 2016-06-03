<?php

namespace Inviqa\LaunchDarklyBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\NodeInterface;

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
            ->end();

        return $treeBuilder;
    }
}
