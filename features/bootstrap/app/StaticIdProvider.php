<?php

use Inviqa\LaunchDarklyBundle\User\IdProvider;

class StaticIdProvider implements IdProvider
{
    private static $userId = 'default';

    public function userId()
    {
        return self::$userId;
    }

    public static function setUserId($userId)
    {
        self::$userId = $userId;
    }
}