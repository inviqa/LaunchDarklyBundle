<?php

namespace Inviqa\LaunchDarklyBundle\Profiler;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

class FlagCollector extends DataCollector
{
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        
    }
    
    public function logFlagRequest($key, $value, Context $context) {
        $this->data = array_merge([$key => [['on' => $value, 'context' => $context]]], $this->data);
    }
    
    public function getCount() {
        return array_reduce($this->data, function($a, $v) {return $a + count($v);}, 0);
    }

    public function getFlags() {
        ksort($this->data);

        return $this->data;
    }

    public function getName()
    {
        return 'inviqa.flag_collector';
    }
}