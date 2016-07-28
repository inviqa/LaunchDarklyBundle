<?php

namespace Inviqa\LaunchDarklyBundle\User;

interface KeyProvider
{
    public function userKey();
}