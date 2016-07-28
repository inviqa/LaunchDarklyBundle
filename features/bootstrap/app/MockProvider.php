<?php

use Inviqa\LaunchDarklyBundle\User\KeyProvider;

class MockProvider implements KeyProvider
{
    public function userKey()
    {
        return 'fixed-key';
    }
}