<?php

namespace Inviqa\LaunchDarklyBundle\Twig;

use Inviqa\LaunchDarklyBundle\Client\SimpleClient;
use Inviqa\LaunchDarklyBundle\Profiler\Context;
use Twig\Extension\AbstractExtension;
use Twig\Template;
use Twig\TwigFunction;

class FlagExtension extends AbstractExtension
{
    private $ldClient;

    public function __construct(SimpleClient $ldClient)
    {
        $this->ldClient = $ldClient;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction(
                'isFlagOn', function ($key, Template $template = null, $default = false) {
                return $this->ldClient->variation($key, $default, Context::fromTemplate(
                    $template
                        ? $template->getTemplateName()
                        : 'n/a (_self was not passed as the second arguments when calling isFlagOn)'
                ));
            }),
        ];
    }

    public function getName()
    {
        return 'launch_darkly_flag';
    }

}