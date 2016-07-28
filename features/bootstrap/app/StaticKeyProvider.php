<?php

use Inviqa\LaunchDarklyBundle\User\KeyProvider;

class StaticKeyProvider implements KeyProvider
{
    private static $userKey = 'default';

    public function userKey()
    {
        return self::$userKey;
    }

    public static function setUserKey($userKey)
    {
        self::$userKey = $userKey;
    }
}