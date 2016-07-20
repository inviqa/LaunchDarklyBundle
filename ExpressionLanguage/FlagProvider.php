<?php

namespace Inviqa\LaunchDarklyBundle\ExpressionLanguage;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;

class FlagProvider implements ExpressionFunctionProviderInterface
{
    
    public function getFunctions()
    {
        return array(
            new ExpressionFunction('toggle', function ($flag, $onId, $offId) {
                return sprintf('$context = new \Inviqa\LaunchDarklyBundle\Profiler\Context;
                $context->type = \'service\';
                $context->onService = %s;
                $context->offService = %s;
                $this->get(\'inviqa_launchdarkly.client\')->isOn(%s, $context) ? $this->get(%s) : $this->get(%s)', $onId, $offId, $flag, $onId, $offId);
            }, function (array $variables, $flag, $onId, $offId) {
                $context = new \Inviqa\LaunchDarklyBundle\Profiler\Context;
                $context->type = 'service';
                $context->onService = $onId;
                $context->offService = $offId;
                return $variables['container']->get('inviqa_launchdarkly.client')->isOn($flag, $context) ? $variables['container']->get($onId) : $variables['container']->get($offId);
            })
        );
    }

}
