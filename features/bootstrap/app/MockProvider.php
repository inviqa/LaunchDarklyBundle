<?php

use Inviqa\LaunchDarklyBundle\User\IdProvider;

class MockProvider implements IdProvider
{
    public function userId()
    {
        return 'fixed-id';
    }
}