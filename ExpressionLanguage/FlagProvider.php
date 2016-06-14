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
                return sprintf('$this->get(\'inviqa_launchdarkly.client\')->getFlag(%s, $this->get(\'inviqa_launchdarkly.user\')) ? $this->get(%s) : $this->get(%s)', $flag, $onId, $offId);
            }, function (array $variables, $flag, $onId, $offId) {
                return $variables['container']->get('inviqa_launchdarkly.client')->getFlag($flag, $variables['container']->get('inviqa_launchdarkly.user')) ? $variables['container']->get($onId) : $variables['container']->get($offId);
            })
        );
    }
    
}