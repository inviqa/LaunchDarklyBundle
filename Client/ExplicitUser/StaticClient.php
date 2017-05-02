<?php

namespace Inviqa\LaunchDarklyBundle\Client\ExplicitUser;

use Inviqa\LaunchDarklyBundle\Profiler\Context;
use LaunchDarkly\LDUser;

class StaticClient
{
    private static $client;
    private static $clientProvider;

    public static function setClient(callable $clientProvider)
    {
        self::$clientProvider = $clientProvider;
    }

    public static function variation($key, LDUser $user, $default = false, Context $context = null)
    {
        return self::getClient()->variation($key, $user, $default, $context);
    }

    private static function getClient()
    {
        if(!self::$client) {
            $callable = self::$clientProvider;
            $client = $callable();

            if (!$client instanceof ExplicitUserClient) {
                throw new \RuntimeException('The inviqa_launchdarkly.user_client service should be an instance of Inviqa\LaunchDarklyBundle\Client\ExplicitsUser\ExplicitUserClient');
            }

            self::$client = $client;
        }

        return self::$client;
    }

}