<?php

namespace Inviqa\LaunchDarklyBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class InviqaLaunchDarklyExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        $configDirectory = __DIR__ . '/../Resources/config';

        $loader = new Loader\XmlFileLoader(
            $container,
            new FileLocator($configDirectory)
        );

        $loader->load('services.xml');
        $container->setParameter('inviqa_launchdarkly.feature_requester.api_key', $config['api_key']);

        $keys = ['base_uri', 'feature_requester_class', 'timeout', 'connect_timeout', 'capacity', 'events', 'defaults'];
        $container->setParameter('inviqa_launchdarkly.feature_requester.options',
            array_filter(
                array_combine(
                    $keys,
                    array_map(function($key) use ($config) {return isset($config[$key]) ? $config[$key] : null;}, $keys)
                )
            )
        );
    }
}
