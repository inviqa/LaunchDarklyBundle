<?php

namespace Inviqa\LaunchDarklyBundle\Twig;

use Inviqa\LaunchDarklyBundle\Client\Client;
use Inviqa\LaunchDarklyBundle\Profiler\Context;
use Twig_Template;

class FlagExtension extends \Twig_Extension
{
    private $ldClient;

    public function __construct(Client $ldClient)
    {
        $this->ldClient = $ldClient;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction(
                'isFlagOn', function ($key, \Twig_Template $template = null) {
                $context = new Context();
                $context->type = 'template';
                $context->template = $template
                    ? $template->getTemplateName()
                    : 'n/a (_self was not passed as the second arguments when calling isFlagOn)';

                return $this->ldClient->isOn($key, $context);
            }),
        ];
    }

    public function getName()
    {
        return 'launch_darkly_flag';
    }

}