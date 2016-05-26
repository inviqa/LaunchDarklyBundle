<?php

class MockClient
{
    private static $flags;
    
    public static function setOn($name)
    {
        self::$flags[$name] = true;
    }

    public static function setOff($name)
    {
        self::$flags[$name] = false;
    }
    
    public function on($name) {
        return self::$flags[$name];
    }
}