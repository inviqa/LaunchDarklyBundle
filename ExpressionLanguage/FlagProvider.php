<?php

namespace Inviqa\LaunchDarklyBundle\ExpressionLanguage;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;

class FlagProvider implements ExpressionFunctionProviderInterface
{
    
    public function getFunctions()
    {
        return [
            new ExpressionFunction('toggle', function ($flag, $onId, $offId, $default = false) {
                return sprintf('$this->get(\'inviqa_launchdarkly.no_context_client\')->isOn(%s, %s, \Inviqa\LaunchDarklyBundle\Profiler\Context::fromService(%s, %s)) ? $this->get(%s) : $this->get(%s)', $flag, $default, $onId, $offId, $onId, $offId);
            }, function (array $variables, $flag, $onId, $offId, $default = false) {
                return $variables['container']->get('inviqa_launchdarkly.no_context_client')->isOn(
                    $flag,
                    $default,
                    \Inviqa\LaunchDarklyBundle\Profiler\Context::fromService($onId, $offId)
                ) ? $variables['container']->get($onId) : $variables['container']->get($offId);
            }),
        ];
    }

}
