<?php

namespace Inviqa\LaunchDarklyBundle\Tests;

use FriendsOfBehat\SymfonyExtension\Bundle\FriendsOfBehatSymfonyExtensionBundle;
use Inviqa\LaunchDarklyBundle\InviqaLaunchDarklyBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Bundle\WebProfilerBundle\WebProfilerBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class AppKernel extends Kernel
{
    private ?\Closure $loadingClosure = null;
    private ?string $id = null;

    public function __construct(string $environment, bool $debug)
    {
        parent::__construct($environment, $debug);
    }

    public function registerBundles()
    {
        return [
            new FrameworkBundle(),
            new TwigBundle(),
            new WebProfilerBundle(),
            new InviqaLaunchDarklyBundle,
            new FriendsOfBehatSymfonyExtensionBundle(),
        ];
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/config.yml');
        if ($this->loadingClosure) {
            $loader->load($this->loadingClosure);
        }
    }

    public function loadConfig(\Closure $closure)
    {
        $this->id = uniqid();
        $this->loadingClosure = $closure;
        $this->shutdown();
        $this->container = null;
        $this->booted = false;
        $this->boot();
    }

    public function clearConfig()
    {
        $this->id = null;
        $this->loadingClosure = null;
        $this->booted = false;
    }

    public function getCacheDir()
    {
        $dir = parent::getCacheDir();
        if ($this->id) {
            $dir .= $this->id;
        }
        return $dir;
    }

}
