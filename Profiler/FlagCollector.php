<?php

namespace Inviqa\LaunchDarklyBundle\Profiler;

use LaunchDarkly\LDUser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

class FlagCollector extends DataCollector
{

    protected $apiKey;

    public function __construct($apiKey)
    {
        $this->data['flags'] = [];
        $this->data['apiKey'] = $apiKey;
    }

    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
    }

    public function logFlagRequest($key, $value, Context $context, LDUser $user)
    {
        $this->data['flags'] = array_merge(
            [$key => [['on' => $value, 'context' => $context, 'user' => $this->getArrayOfUserDetails($user)]]],
            $this->data['flags']
        );
    }

    public function getCount()
    {
        return array_reduce(
            $this->data['flags'],
            function ($a, $v) {
                return $a + count($v);
            },
            0
        );
    }

    public function getFlags()
    {
        ksort($this->data['flags']);

        return $this->data['flags'];
    }

    public function getName()
    {
        return 'inviqa.flag_collector';
    }

    public function getApiKey()
    {
        return $this->data['apiKey'];
    }

    /**
     * Yep it returns an array despite the name!
     *
     * @return array
     */
    private function getArrayOfUserDetails(LDUser $user)
    {
        return [];
    }

    public function reset()
    {
        $this->data['flags'] = [];
    }
}