<?php

namespace Inviqa\LaunchDarklyBundle\Twig;

use Inviqa\LaunchDarklyBundle\Client\SimpleClient;
use Inviqa\LaunchDarklyBundle\Profiler\Context;
use Twig_Template;

class FlagExtension extends \Twig_Extension
{
    private $ldClient;

    public function __construct(SimpleClient $ldClient)
    {
        $this->ldClient = $ldClient;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction(
                'isFlagOn', function ($key, \Twig_Template $template = null, $default = false) {
                return $this->ldClient->isOn($key, $default, Context::fromTemplate(
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