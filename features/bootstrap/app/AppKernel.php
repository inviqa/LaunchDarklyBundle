<?php

use Inviqa\LaunchDarklyBundle\InviqaLaunchDarklyBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class AppKernel extends Kernel
{
    private $loadingClosure;

    public function registerBundles()
    {
        return array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new TwigBundle(),
            new InviqaLaunchDarklyBundle,
        );
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/config.yml');
        if (isset($this->loadingClosure)) {
            $loader->load($this->loadingClosure);
        }
    }

    public function loadConfig(\Closure $closure)
    {
        $this->loadingClosure = $closure;
        $this->boot();
    }

    public function clearConfig()
    {
        unset($this->loadingClosure);
    }

    /**
     * Remove check to allow rebooting the kernel when passing new config options
     */
    public function boot()
    {
        if ($this->loadClassCache) {
            $this->doLoadClassCache($this->loadClassCache[0], $this->loadClassCache[1]);
        }
        // init bundles
        $this->initializeBundles();
        // init container
        $this->initializeContainer();
        foreach ($this->getBundles() as $bundle) {
            $bundle->setContainer($this->container);
            $bundle->boot();
        }

        $this->booted = true;
    }

    /**
     * Remove caching of container to ensure passed config is used
     */
    protected function initializeContainer()
    {
        $container = $this->buildContainer();
        $container->compile();

        $this->container = $container;
        $this->container->set('kernel', $this);
        if ($this->container->has('cache_warmer')) {
            $this->container->get('cache_warmer')->warmUp($this->container->getParameter('kernel.cache_dir'));
        }
    }

}